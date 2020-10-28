<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<title>My block robot spasms</title>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="expires" content="0" />
<meta name="author" content="Ing. Inoel Garcia" />
<meta name="description" content="Certificado Copyright" />
<meta name="keywords" lang="es" content="block robot spasms" />
</head>

<body>

        <style type="text/css">

            body {
                font-family:"Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana;
                font-size:15px;
            }

            #intro {
                background-color:#CFEBF7;
                border:1px #2580B2 solid;
                padding:5px 13px 5px 13px;
                margin:10px;
            }

            #intro p {
                line-height:	16.8667px;
            }

            td {
                font-size:11px;
            }

            th {
                text-align:left;
                padding-right:30px;
                font-size:11px;
            }

            tr.high {
                background-color:whitesmoke;
            }

            #footer {
                padding:2px;
                margin:10px;
                font-size:8pt;
                color:gray;
            }

            #footer a {
                color:gray;
            }

            a {
                color:black;
            }
        </style>

    </head>

<!doctype HTML public "-//W3C//DTD HTML 4.0 Frameset//EN">
<html>
<!--(==============================================================)-->
<!--(Document created with RoboEditor. )============================-->
<!--(==============================================================)-->

<!--(Links)=========================================================-->
</head>

<!--(Body)==========================================================--><div id="logo">
<center><img src="./svg/loading-dark.svg"></center>
<?php
require_once("plugin_sitemap_reader.php");
$rss = new RSSFeed;
$rss->feedurl="../sitemap.xml";
$rss->cachefile="0000009ad50b04203.txt";
$rss->bulletfile="bu0000009ad50b04203.gif";
$rss->expires=3600;
$rss->maxnewscount=10;
$rss->footer="Final Sitemap";
$rss->errortext="Estamos Actualizando las Noticias";
$rss->showdescription=1;
$rss->sidebarmode=0;
$rss->process_feed();
?>

</body>
</html>