

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Auto Fetch</h3>
  </div>
  <div class="panel-body">

<div class="row">
    <form action="" method="post" enctype="multipart/form-data">

    <div class="col-lg-12">

      <!-- Add new -->
     
      <p>
      <label><strong>Select method:</strong></label>
      <select class="form-control" id="method">
        <option value="manga">Auto Fetch manga</option>
        <option value="chapter">Auto Fetch chapter</option>

      </select>
      </p>

      <div class="pMangaOptions" style="display:none;">
      <p>
      <input type="radio" class="rdUpload" name="rdUpload" value="host" /> Upload images to your host
      <input type="radio" class="rdUpload" name="rdUpload"  value="url" checked /> Not upload

      </p>
      <p class="pChosen">
      <div class="row">
      <div class="col-lg-12">
      <label><strong>Choose a manga</strong></label>
      <input type="text" class="form-control txtAuto" data-maxselect="1" data-numselected="0" data-method="manga" data-key="jsonManga" placeholder="Type manga name here..." />
              <div class="listAutoSuggest"><ul></ul></div>  
                <ul class="ulChosen"></ul>
      </div>
      </div>

      </p>  
      </div>

      <p>
      <label><strong>Select a site to Fetch:</strong></label>
      <select class="form-control" id="category">
        <option value="none">None</option>
        <?php
        $total=count($listSite);

        $li='';

        if(isset($listSite[0][2]))
        for ($i=0; $i < $total; $i++) { 

          if(!preg_match('/(\w+)\.php/i', $listSite[$i],$match))
          {
            continue;
          }

          $li.='
          <option value="'.base64_encode($listSite[$i]).'">'.ucfirst($match[1]).'</option>
          ';
        }

        echo $li;
        ?>
      </select>
      </p>
      <p>
        <textarea rows="8" class="form-control" id="txtListUrls" placeholder="Type list urls here..."></textarea>
      </p>
      <p>
      <button type="button" class="btn btn-info" id="btnStart" name="btnStart">Start Fetch</button>
      </p>



  
    </div>

    </form>


  </div>    
    
  </div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Task status</h3>
  </div>
  <div class="panel-body">

<div class="row">
		<form action="" method="post" enctype="multipart/form-data">

		<div class="col-lg-12">

			<!-- Add new -->
      <p>
      <div class="taskStatus">Status: <span class="outStatus"></span></div>
      </p>
		</div>

		</form>


	</div>    
    
  </div>
</div>


  <script type="text/javascript">

	var root_url='<?php echo THIS_URL?>';

  var listUrls=new Array();

  var totalUrls=0;

  var curPosition=0;

  var mangaid=0;

  var uploadMethod='url';

  ready(function(){

    $('input.rdUpload').click(function(){

      uploadMethod=$(this).val();

    });

    $('#method').change(function(){

      fetchMethod=$(this).val();

      if(fetchMethod=='chapter')
      {
        $('.pMangaOptions').slideDown('fast');
      }
      else
      {
        $('.pMangaOptions').hide();
      }
    });

    $('#btnStart').click(function(){

      $(this).val('Starting...');

      listUrls=new Array();

      totalUrls=0;

      curPosition=0;      

      var fetchMethod=$('#method').val();

      var fetchCategory=$('#category').val();

      var fetchUrl=$('#txtListUrls').val();

      if(fetchMethod=='chapter')
      {
        if(parseInt(mangaid)==0)
        {
          alert('Error.');

          writeStatus("You must choose a manga for fetch chapters.");

          return false;
        }
      }

      listUrls=fetchUrl.split("\n");

      totalUrls=listUrls.length;

      // alert(totalUrls);return false;

      if(fetchCategory=='none')
      {
        alert('Error.');
        writeStatus('You must choose a site to fetch.');
        return false;
      }

      startFetch(fetchMethod,fetchCategory);

    });

  });

  function startFetch(fetchMethod,fetchCategory)
  {

    if(parseInt(curPosition) >= parseInt(totalUrls))
    {
      $('#btnStart').val('Start Fetch');

      writeStatus('Completed fetch content from urls.');

      return false;

    }

    if(listUrls[curPosition].length < 4)
    {
      curPosition++;

      startFetch(fetchMethod,fetchCategory);  
      
      return false;   
    }

    writeStatus('Task: '+curPosition+' . Fetching content from url: '+listUrls[curPosition]);

      $.ajax({
       type: "POST",
       url: root_url+"process",
       data: ({
          fetchMethod : fetchMethod,
          fetchCategory : fetchCategory,
          fetchUrl : listUrls[curPosition],
          isUpload : uploadMethod,
          mangaid : mangaid
          }),
       dataType: "html",
       success: function(msg)
              {
                alert(msg);return false;
                curPosition++;

                startFetch(fetchMethod,fetchCategory);

               }
         });  
 
  }

  function writeStatus(msg)
  {
    $('.outStatus').html(msg);
  }

 $( document ).on( "click", "span.removeTextChosen", function() {

  var txtAuto=$(this).parent().parent().parent().children('.txtAuto');

    var theMaxSelect=txtAuto.attr('data-maxselect');

    var theNumSelect=txtAuto.attr('data-numselected');

    theNumSelect=parseInt(theNumSelect)-1;

    txtAuto.attr('data-numselected',theNumSelect);

    if(parseInt(theNumSelect) < parseInt(theMaxSelect))
    {
      txtAuto.attr('disabled',false);
    }   

    $(this).parent().remove();
});             
$( document ).on( "mouseout", "div.listAutoSuggest > ul",function(){
  // $(this).slideUp('fast');
        });  

$( document ).on( "keydown", "input.txtAuto", function() {


  var theValue=$(this).val();

  var listUl=$(this).parent().children('.listAutoSuggest');

  var keyName=$(this).attr('data-key');


  if(theValue.length > 1 )
  {
    $.ajax({
     type: "POST",
     url: root_url+keyName,
     data: ({
        do : "load",
        keyword : theValue
        }),
     dataType: "html",
     success: function(msg)
            {

             // $('#listtenPhuongAuto').html('<ul>'+msg+'</ul>');

             // $('#listtenPhuongAuto').slideDown('fast');
              listUl.html('<ul>'+msg+'</ul>');

            listUl.slideDown('fast');

             }
       });            
  }

});    

$( document ).on( "click", "div.listAutoSuggest > ul > li > span", function() {

    var theValue=$(this).text();

    var theID=$(this).attr('data-id');

    var theMethod=$(this).attr('data-method');

    var txtAuto=$(this).parent().parent().parent().parent().children('.txtAuto');

    txtAuto.val('');

    var theMaxSelect=txtAuto.attr('data-maxselect');

    var theNumSelect=txtAuto.attr('data-numselected');

    var numLi=$(this).parent().parent().parent().parent().children('.ulChosen').children('.li').length;

    if(parseInt(theNumSelect)==0 && parseInt(numLi) == parseInt(theMaxSelect))
    {

      txtAuto.attr('disabled',true);

      $(this).parent().parent().parent().slideUp('fast');

      return false;
    } 

    var newLi='<li><span class="textChosen" >'+theValue+'</span><span title="Remove this" class="removeTextChosen">[x]</span>';

    if(theMethod=='manga')
    {
      newLi+='<input type="hidden" name="send[mangaid]" class="valueChosen" value="'+theID+'" />';

      mangaid=theID;
    }

      newLi+='</li></ul>';

    $(this).parent().parent().parent().parent().children('ul.ulChosen').append(newLi);
    $(this).parent().parent().parent().slideUp('fast');

    theNumSelect=parseInt(theNumSelect)+1;

    txtAuto.attr('data-numselected',theNumSelect);

    if(parseInt(theNumSelect) >= parseInt(theMaxSelect))
    {
      txtAuto.attr('disabled',true);
    }

});    
  </script>
