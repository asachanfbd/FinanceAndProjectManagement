<!DOCTYPE html>
<html>
<head>
    <title>[#:@`pagetitle`]</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="styles/afterlogin.css">
    <script src="js/jquery-1.8.3.js"></script>
</head>
<body>
    [#:@`loginbar`]
    <div id="maincontainer">
        [#:@`subnav`]
        <div id="bodycontainer">
            <nav>
                [#:@`mainnavigation`]
            </nav>
            <section id="mainbody">
                <div>
                    [#:@`mainbody`]
                </div>
            </section>
            <footer>
               <div>[#:@`footer`]</div>
            </footer> 
        </div>
       </div>  
       <div class="bottom_line"></div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
