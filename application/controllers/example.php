<?php

class example
{

    //Default function will be run first.
    public function index()
    {
        echo 'Controller example.';
    }

    public function a()
    {
        echo 'Func a.';
    }

    public function view()
    {
//      if click onto button Send
        if(Request::has('btnSend'))
        {
            $post=array(
                'fullname'=>'require|min:5|max:30',
                'email'=>'require|email|min:10|max:80'

            );

            $valid=Validator::make($post);

            if($valid)
            {
                echo '<p>All field is valid</p>';
            }
            else
            {
                echo '<p>All field is not valid</p>';
            }

        }


        View::make('example');
    }

}

?>