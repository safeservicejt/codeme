<rss version="2.0">
    <channel>
        <title>
            <![CDATA[ <?php echo $setting['title'];?> ]]>
        </title>
        <link>
        <![CDATA[ <?php echo ROOT_URL;?> ]]>
        </link>
        <description>
            <![CDATA[ <?php echo $setting['description'];?> ]]>
        </description>
        <ttl>10</ttl>
        <copyright><?php echo ROOT_URL;?></copyright>
        <pubDate><?php echo date("d/m/Y h:m:s");?></pubDate>
        <generator>NoblesseCMS</generator>
        <docs><?php echo Url::rss();?></docs>
        <image>
            <title>
                <?php echo $setting['title'];?>
            </title>
            <url>
                <?php echo ROOT_URL;?>bootstrap/images/logo3128.png
            </url>
            <link><?php echo ROOT_URL;?></link>
            <width>128</width>
            <height>128</height>
        </image>

        <?php
        $total=count($listPost);

        $li='';

        if(isset($listPost[0]['title']))
        for($i=0;$i<$total;$i++)
        {
            $li.='
                <item>
                <title>
                    <![CDATA[ '.$listPost[$i]['title'].' ]]>
                </title>
                <link>
                <![CDATA[
                '.$listPost[$i]['url'].'
                ]]>
                </link>
                <image>
                <![CDATA[
                '.ROOT_URL.$listPost[$i]['image'].'
                ]]>
                </image>
                <guid isPermaLink="false">
                    <![CDATA[
                          '.$listPost[$i]['url'].'
                    ]]>
                </guid>
                <description>
                    <![CDATA[
                    '.htmlentities($listPost[$i]['content']).'
                   ]]>
                </description>
                <pubDate>'.$listPost[$i]['date_added'].'</pubDate>
                 </item>

            ';
        }

        echo $li;
        ?>


    </channel>
</rss>