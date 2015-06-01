<?php

class Captcha
{

//    private $thisHash = '';

    public function make($is_text = 'no')
    {
        global $uri;


        $main_img = imagecreatetruecolor(250, 78);

        $bg_color = imagecolorallocate($main_img, 255, 255, 255);

        imagefill($main_img, 0, 0, $bg_color);

        $captcha_str = String::randNumber(5) . '' . String::randNumber(5);

        $dbColor = array(
            0 => array(100, 161, 39),
            1 => array(64, 64, 64),
            2 => array(65, 192, 209),
            3 => array(237, 89, 26),
            4 => array(237, 26, 72),
            5 => array(163, 39, 161),
            6 => array(78, 207, 96),
            7 => array(219, 24, 157)

        );
        $dbRotator = array(
            45,
            10,
            30,
            -5,
            -10,
            -30,
            -50
        );
        $dbUpDown = array(
            55,
            40,
            50,
            45,
            35,
            30,
            65

        );

        $font_file = ROOT_PATH . 'uploads/Eirik Raude.ttf';

        $strLen = strlen($captcha_str);

        $space = 20;

        for ($i = 0; $i < $strLen; $i++) {

            $colorRand = rand(0, 7);

            $rotatorRand = rand(0, 5);

            $updownRand = rand(0, 3);

            $black = imagecolorallocate($main_img, $dbColor[$colorRand][0], $dbColor[$colorRand][1], $dbColor[$colorRand][2]);

            imagefttext($main_img, 30, $dbRotator[$rotatorRand], $space, $dbUpDown[$updownRand], $black, $font_file, $captcha_str[$i]);

            $space += 20;
        }


//        $colorRand = rand(0, 7);
//
//        $black = imagecolorallocate($main_img, $dbColor[$colorRand][0], $dbColor[$colorRand][1], $dbColor[$colorRand][2]);
//
//        imagefttext($main_img, 30, 0, 15, 55, $black, $font_file, $captcha_str);

//        Create session
        $hash = md5($captcha_str);

//        self::$thisHash=$hash;

        $_SESSION['captcha'][$hash] = 'OK';

//        End create session

        if ($is_text == 'no') {
            header("Content-type: image/png");

            imagepng($main_img);
        } else {

            $savePath = ROOT_PATH . 'uploads/' . String::randAlpha(12) . '.png';

            imagepng($main_img, $savePath);

//            $dataImg = ob_get_contents();

//            ob_end_clean();

            $dataImg = file_get_contents($savePath);

            unlink($savePath);

            return 'data:image/png;base64,' . base64_encode($dataImg);
        }


    }

    public function verify($inputName = 'captcha_verify')
    {
        // print_r($_SESSION['captcha']);die();
        if (isset($_REQUEST[$inputName])) {

            $text = md5($_REQUEST[$inputName]);

            if(!isset($_SESSION['captcha'][$text]))
            {
                return false;
            }

            $verifyStatus = ($_SESSION['captcha'][$text] == 'OK') ? true : false;

            if($verifyStatus)
            {
                // $_SESSION['captcha'][$text]='';

                unset($_SESSION['captcha'][$text]);
            }

            return $verifyStatus;
        }
    }

    public function makeForm()
    {

        $dataForm = '
     <div
        style="margin:0px;padding:0px;min-width: 280px;min-height:140px;max-width: 280px;max-height:140px;background-color: #2885BF;color:#ffffff;border-radius: 3px;padding:3px;">

        <div style="margin:0px;padding:0px;float:left;width:100%;min-height:78px;max-height:78px;background-color: #ffffff;border-radius: 3px;">
            <img src="' . Captcha::make('yes') . '" border="0" style="margin:0px;padding:0px;" />
        </div>
        <div style="margin:0px;padding:0px;float:left;width:100%;min-height:72px;max-height:72px;margin-top:0px; ">
            <div style="margin:0px;padding:0px;float:left;width:150px;min-height:52px;max-height:52px;background-color: #629C24;border-radius: 3px;margin-top:5px; ">

                <span style="margin:0px;padding:0px;margin-left: 5px;color:#ffffff;">Type the characters:</span>
                <br>
                <input type="text" placeholder="Type the characters.. " name="captcha_verify" style="color:#000000;margin:0px;padding:0px;border:1px solid #D4D4D4;width: 140px;margin-left: 5px;height:30px;max-height:30px;border-radius: 3px;" />
            </div>
            <div style="margin:0px;padding:0px;float:left;width:115px;min-height:52px;max-height:52px;margin-top:0px;margin-left: 0px; ">

                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHMAAAA0CAYAAAC5HgcyAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAABZnSURBVHja7Jx7cFzVnec/5/a7W2/Z1sNPLOMXtsHINsYBgoNhIESAkzFDajIku8kaUjWT3U2qxtTuTrZqZ7Nj12ZTbG1mM7i2SCozyRB7SAABJkgYbGPjlyz8wBayLetpvbrVavXzvs7ZP/q23XSEJWGTMCn9qk71fZzXPd/z+53f/Z7fbaGUYlr+OESbHoI/HnHnDoQQlJTNwucPUVExi8rKWVTVzCUcHuDggT0IJVHSYsVt95CIRxmLjZBOjZFMjFJdu5BQUSkX21u9QmilHm+oSCmJZabGlFKJezdtNsrKq9V7B99kNBqhpKyS4f6LhIpnMmf+Es6fO8q8m24hFCohOjJIfCyKnknjcglKyyoZuNzBtAWZApifRIQQAIxGw0tmz1vyzc2PP72qpDhUVlE5o8SyLBUOR6OxsbFRj9uTGh4euhyPx39jGPq+XLlp+YyAKYQgEY9SXDbzkQcf/vO/3rz5z1YsWTy/OOQXWijkRdNA100yum4racnYWCLTvPfAg7/85e6X284c/Xuge3r4PwNgCiGIRYc9NXMWb3340W/8ZcMjTyy9uW4+AT+UFEFF6UeWYpeTPKtWLFly660rvv1Pv9i1qumN1385GundrZTKTMPwBwQzNhqZs2jp6m83PPZvvnnvxoaqsrJKoqMpRKmkssyHZXqIhNMEQhrBoIdwJMbwYIqaqlk88tDni1csX/zgHevWLf/Ni7++81JX9y5pG+9IKZk2v78nMJVSSGmTTCZuW7p8zV82bP76N9bfeZ/L5fKTTCaYUQnzZofQELSeusCpjlbuW/85Skrm0Bu+RFNrMyWBmdx7yyaWLprP977z9Xnr1q7+9j+/8C9r3nhd/qNhcWwsNhpJJhOJRCIeV3Ymobk80wDfaDCVlCgpvWUV1Z9bvGTlf3r8q09vWr58NYZpY+hx5tR4mF8bwMwYvHfmNPvbX6Nfb6E+XYey55CwBomU7qMznSHc0snK3rtZt+J27r5zFatuWbZ2/fr19Xv3Hjg+HB7uTCdiw4lEdDiZTAzF47G2dCp1DEhMQ3UDwJRSopQsnz237qEvPfrkDx7d/LUFs2vnkkikQRrcNNfH7Co/I5EY7xx/jyP9L6Pd1EZJRpHSdRIjkE4pgoEA3tpRMvq77Os7w7m31rB2wUbWrlrBk098UXvwgT9ZNxRJrMukE1hWithojH373+34yf/94XeBV4Dpd5OpgqmUcimlPEopl5RSU1KVzZ2/+MlvfPN7f/PII1/xhYJFxONJPB7J3Fo/M8u8XOwY4M3jr9NmvUbx0gg+d5DEmCI6YtGnFLGYhW0JhOEn4C3CvzDJWLKZPb2tnOy+gw1L/oRVS25mWV0JklI8rmxffD53za9e+MVDo+G+PYAxDdcUwRSC24GNwKJ0Kjnj5iUrF//F17+9/J57Pi9cLjepVIpQCObUBAi6PRw53kbzuV8RKTlE2TyJpoqRpkIqg/BIEl8mQTiWwA5YeDQN2xKAj6DfS7AuQTixhxcvHONU90ZunlXP3Op5VM0qx+f3kUqmpJK2BvinwZwimOlUcsXmr3zjx1u2fGX57OqZbolL8/qL3aFgULg0gS0NAhWCqsoQRgJePbCXI4O7MGacp6jYA5YPCWgClEdnYGgINZQm6hlClqTQhAdlO9ZSCVBuAgEXvrlxevXXON3zIovC9/Bo/b9lYckcbKlytnXaC5oimMLjC62tr7/9pnXrVhe5NA+ZjEnAD5omkbYk4A/g9wg6O+M0v/8ibZk3kTMG8Ae9COlGKQEolCbwBT1E3EeIJ2NYpafx+AHbjVIKIQRKgc/twe3TsEwb02WhVY5gqH4MKwlycotkQ0ND/mk9sNVJ+dIMtAA7gKhzrRwYuUbVO4DdTrmPkyZgk3O8E3jqY/JtB7Y5xx1AXe5GY2Nj4fOUAxed/gHsaGxsfGbKYGqaVu5yeTAMDVsppGXh9ymEEgih0d0zSHv3Wc4OH+SyPI4oHcPv9yFsN1IpEAoESClwa37Mqi7Mij5cfhtN86JsUAo0t8Dl0rg8MEjnhX4WLq6ltqaaoD+ApgukUtgym3cKkj9ghbLJSduANRMAlJNtTnrGAbZQyp3Jk9/GZGShU++Oj7m/NQ/IKUk+VSNQUmUMi1RGYloqC6jKkjixxBiNLT+lqecndPE2rrIEPq8fLDe27eRToCQgFUoJ3H6FuzSNy6tAakgJQtNASMKREUYveNkw8wl6Txlc7hvCtiUCF1IJpAPmJO3rtjwgmx3AhJMqCjRyPHkmL78AHnfqyU2SrdcY9GgeSFsm6Gc0ryzXAJMJ+jshmCCumrbcu7qSAqU0EpkYF2L7MUq7CJZpuIUfZWnYUiLJAiml86tASoWyXGD6kLaGlFkN1zQYHR2jvz3DY6ue5umHn2HLbf+eZF+A6MgYLpeGUsKZRJOW3AC0APcXaF7UAasiD6CJZLdTT0feZBlP23PmtWWS2tnh5F04Xp0NDQ3bnHu7r1czx2ELHGBsUCj8AR8BVxmYXqSlUFJl0ZcK5WiSkjntzLJGyrknJbjcLmLxMQY706yvfow/3fQEFRWlfPWhr1Fs1xAfTaEJkdVOyWQBLXcGgEmAdf8kTSx5QOW0rrzAVG7KazM3+FsmUeeOa2jn1oI8NwZM4aCplMquh1JkTaWlsl6mA5CUZNdCqfISV8ykkiBthUvTSOspBnsSzHOt5alHvnulrXffP4DpjxIIeUF6EcqNbTuaPrFEC0zd70O25GlaPpjlE5jQnNZ3FJrlhoaGLTmtbGxsbLkxYCqHh1USqRxA8lMOsLxrWbIh+7qhnPJXgJQgEAih6OkapFyv41sPfo9QkR+A7v5ufvLbv0WWRygrLQHLgya8WDbYlo1E2pN4jua8Qd5+A0FbOM6EyQdzdwGok3WEdo5jvrcV3Ls+MIVD39m2jbRtpC2z2gcgXAjlzmqcvAqqUAJb2tjOmBfel1Lh9bnp6u3BM1bFl9d9i5sXZD3zZCrJ/9r1fdxVUSorS8By41J+3C4/lg0Zw7Qt08rgdGECByZ/fVPA8Qk83MkAuWUc812f58U2jzOhNk3CG93h9Le+oaFhS0NDQ67OlsbGxuYbAiZoSCWxbAvLsrBsO8vNStBw48KLbV/VSp/PSzgc5cTBS7Qe6mJgcJhAwH9l3ZQ2eD0eBsIDxHoFm5Y9wefXbMwSFHqa//fqj+lVLVTXVKDhxjQlXlcIjzuIbkIinrIz6WQcsCbhWKwpmNX1DpDbHXB3TcEMb3PeIcvzHKhCx6ejAMydTt7ySa6dO8fxxHdcjxkZ18zalo1pWg7J7phK4cYlvI6XKvH7/Hx48TxmOMh3H97Bdx78b/R/qHP67Af4A36UApfmImMmuXhumC8sfpzNn38ct8uNYZi8dewN3vzw5yxYVIVL82BZFtguvFoxXpeXTMZkeDhsjI2NDALXMrVlTlLOoJQ7dOSzwEsFpvEtYIGTv7TgHVXlpe0O8KPAdx1yIdfO006ZV/Ku5do/6dz7asE9n3PdlXftV0799U7f3geaGhoayhoaGsryWC+fcz41Ok8pW1qWpUzLQtMEmpBYtsKlCRAuXMKPsm2Ex8twJAyxEhrWP8kD6x9GKYnb7eHvX/tbTugnuW3VClwuwbHDbWyY82X+9O6vUxQsAuDUhVZ+9vYPqV1UjNfrR9ogpYXb9hNwleFxC4ajCfr7e3VTT/ROoJlTeR9bAFyaQv4y4KdOKpT/4KTx5N6P6ddt1+jvx93LtSOmBKZp6Kl0OmWbhoHLpSGEwrLB5wGX8BL0FDOkSzSXi86uHj4358s8UN+A3+cF4IsbHsXn8fGTPdtpPXkKw9apK7qTP7v7W8yuqgXgQvdFnm/6EapihBkVi7BNGxCY6HipIOSZgeaCaGyMvt6uEZTsmWDN/I+TBOa/AJVAD/AjIAj8wLn3qqO1E8mXgPsm2V5+nblyubZzEgT+M5AG/ntB+R84999y6pqSZkrDSEei0YiVTqfx+31IqTBNifKBJtwUeWdgJxTSVhQXFdM1fJ5TF1u5d80XsjbEpfHA+i/icft4vumHZKw0T37hr7ilbiUAQ5EhXnhnJxcTR7l19RIsI0vACpdA13UqXbMo9s3CVjAUDsu+3q5eoH+CZ3h2koP7sLPeDTllyvPAfHeS9fxVnsO1YwK+tiavzmoHzKHCdhobG//Hx3DO33fAPN7Y2PjsVMFUSpr9fX29Y7FYDLe7AtO0MQzboepclPirkSYYGZO5tXP54NwH/MOe7ZiWwRfW3I/Lnd2I3LjmPkK+ELaSrL1lHZomiCfivPTuP/PupZepWzYbTXoxLAMhBC4NjIxFaXAOJYFZZHTov3w51X+56+IEZHjO0dnuUHDRaxAL9ZMkFrgGvzsZcqLZyVvv5O/4fe2aFDpAfX09nX3hSFgZpolu6OiGiSUlCqgI1YJ0Y1kSZWssX7aYy/pZnn3pv7LnvVdIZdJXKlq3cj13rtqA2+XGsmyajr3OnjO/pLzWT1loBpmMfuUVRkobZbgo882jKFBOLG7R1dUxGg1fPgfokxzoEeC5cTzJrQWe6Sd9j9tSQMldy0uNToER+tTAjAwN9l4cGhxMGbqBaehkMhksO7tkVRTPxqOKQIKhGyhDY/XK27BCYX70m+/z2qGXSaZ/N1ynta2Fl4//DDsQZV7NfBLJdB7BALqp45UVVPgX4PO56R/s50L7uWHDSJ6dJAOUD9yuAs/0OUdLos4WVcd1aOZkXuqjeWD/QcFMRsID7QMDvWOpdAbDsEim0hiGja0ExcEqSn1zkJZEKYlpWxgZi6WLllFao/G/X/obdjX/E7pxVZmGR8L8tPlZInYndfPrSCcMhxm6yuemM0kqPXVUhOajFFzsaFftbe+fB85P4hk6HE/vmY8Z6KizvtV9UgLbAWXhFMz07nEIhk9dfidsJBmPnOvt7hqJxeI1oaCfVCpFKm1QHAri8wSpKlpEONqG0izcwodtSXTbpLa6Fr9vhOff+p+MJWJ856vbEMCPf/139KXPUlM7C2lqSNu+stGkhEIDzKRF7azVlBfVEB2TnD3z/mB3V9txIDLRA+Rt7uYckqcm+exRJh/BsJupRTvsLJhYLQXEA5N4rorrBhNUe3f3xa5wePgW/+zZGGaaRDJFcSgIwNzKlZwJv4G0DdBymyYKZUhKi8tw3+zhpRM/ZSQRQROCs+HDlFcWEfAEsUzn3V+o7B6bAFPq+O0qZpfdSjDk59SZdk6fOnopkx47DJhMy3Xtmlzu7vrwxKWO9piu6xh6hthoDEsKLNtm3syVFImZSCvL4yKv7oxICaFAiNnzK2kdaOb9wbcoKvcS8BVhmdlXmiskvMPQxxNxbiq9i6rSRegmvN96RG8723IMpT6Yhuf6wdSjkf53PjjTcn44HMG2baLREZJJHakUpUXVzCtfi7IEhqlnHRln7ZO2wrahOFRC2YwQJZVBfF4vSK5wujkiXkqFael4jQqWVD1ASVE5lzr7OXp47/nwUPdePsFO+zSY44i0rRPt507sO//hBynTtEgkYgwODiKEC6kUq+Y9SIAZmHoWYKk+uktimjZBbxEBbwjbVthSOp83XN0+k7ZNKp5mWcWXqClfjqng2LF91pmThw5I2zzGdNDzjQETiEaGe18/+f7B1oGhQUzTpK+vi2TaxLAyzJ21nEWVGxG2n4yRQKBliQV5NZmmjWnaV8zwlV8lsG0LXdepEMtZNXczgUCQS519HNzX+OHgQGczMDANzY0DEynt4+3nTrx65tTx0UzGIDYapqe3Nxu8haR+4WPUBG9FTxlYtoFAXCUBVC6c5GoYSQ5IKRWGoeM2y1gz5y+oKJlLImOy7+1X0qdOHHjDtowjTLx/OS1TARMYi49F9pxs2f9qd3eHadkWXZc+JDaWJplJUF0xh/p5j1PpvZlUagypbBQiLw5IfSQGKOvvKAwzg2YGWFz2MIvnbMRQFidPHaf5jRcOh4d790yCi52WTwAmQNvlvgsvHTvy9unoSEzGRiNcutSObkjieoal8+9i7fw/J6hqSKXjKORVMB12R+aFkZiWjq0rqn1ruaPuSWxlMTw8yJ5Xfj50vq3lX0CdmNbKTw9M3TQyh9rOvPfzY0f39qRSaXq62hkaGiZjGOhWmpU3PchddU/hNWaQTI06jP1HzauSAqksUskkle4VbKj7d/gCIVKZOG/vfUUd2v/KLj2TfIfsZu20fEpgAgynU4k9LUfffO7o0bc7I9Eo7edaiY2OYtgS0zZZPv9+HrjlrylRC4nGBrCkCSK7hgoEEpPRsTCzvLfyubqnqZqxgLSZ4sjR/TS++NxvR0cGXyK7aTztwd5IOm8csUBdSifjv2k90mQk47Gv3br6rtvcHh8rbl1HeUUl0rSZX7WOh/wVtHTs5vzwWyRdI/h8QZSwyKQyLCq7j/WLvsX8mpUYts7J1kO88I/PHu26dPZnUtqtZDdob4Q0OXztU/+KcWlyOOAdNxpMHFrtQjodf/HcmUORkcjlxwb6uzamMsmStevuZVZVLbZpMbNsMXctfYqbZm2gO3KU3tFWMmaS26rv5/b5X6FmVh1pPcHhI3vZ/Yv/c+Lc6YP/YFvmvvHMq1IqF+hUnsd3flYAut6+fSoTbip/UGEBXYaebuzpPNcdiw6393S13dvT2b7y7o2P+BctWo4/6Mfnm0NxYCa1ZSsJxy9hSZOa8mXMKKthJDrIvv2v8eqvnz909szh55W03wAGC82rUioX//qUEGKnUqqe7FbWZ0Gu9M0B8TPTN5HjSKf4RxBeYDZwR1lF1X3Lb7ljw4Z7vrhwxap1/hkzqwkFQvg8IUDDpQlSmTidXW0c2L8n/tZvdx/o6jjzc8eMjIy3TiqldgEdQohn8q5BdhtqF1e3lXLhG7mQSvI0ZUdB3txeZhPZXYx6srshC53jZrKfL2xywFnoUIqFnzTscuop3AXJfU6Y34cc0Ln2Wpzr+eDXOX3fklcu9zlEft93Fzxjrq7rBjMnQWAecGflzNn3LV2+dvWyFWuq582vKy4vr/QUFRUDiq5L560D+3/bc+xwc9PY6NAu4DCQ/LhKlVJNQLMQYkcBmLuc08edh99FNl72uHNtd54JKx8n7+N5ZRbmXetw6qhzfnc4absD7poprme5ybDbOV6T18ZuB6Scmd3mTIL8D5WanN/7P6YPW516xSc1s+NJCmgDLkeG+1oO7utbdfRw0+3VNQuWzKqaXTNjZk25bZnqQvvp9s6O03ucTl5k4lCQKONHhdfnDWL+BnAHv7vxnIvBydf88rxZHc07piDP9jwt6Jhk3zY5ZerHKZdro3mcsgud64XtNOfVk/s46jk++vnDR2KM3DfIXI8Bp4BLpp482NP5QVVP5wfVZEMbLafBdrLRaZN5/WgGnlNKdRSsmS3Ow+zMM0steaayI+8BcxHnTxUM+LUkP4J957X65tSfb0rLufptaL55zx/4XN/L80DtcDRtouCv3Od+Ypxl5ar5usH/GCkAD1DigFlO9g8mpmTHlVLb1Edlu1JqoVLqeN61bU7/n3POR5RSF53zwrxNSqlNzjHOfeX85h9vcuoobCM/jde3rXnnx506thbka3LKb8rr20Lnek6ec85z7W516qp3nk8VlL3SLzH915+fqoy7tv0hGaBp+Vci05r5RyT/fwCuD1do97VmOwAAAABJRU5ErkJggg==" style="margin: 0px;padding:0px;border:0px;border-radius: 0px;" />
            </div>

        </div>

    </div>

        ';

        return $dataForm;

    }


}

?>