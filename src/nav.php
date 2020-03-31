<link href="/src/css/listPage.css" rel="stylesheet">
<div class="container-fluid">
    <div class="container">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar-scroll">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img src="/imgs/IFTTT.gif" style="width: 180px"
                                    alt="noshow"> </a>
                </div>
                <div class="collapse navbar-collapse navbar-right navbar-1-collapse">
                    <ul class="nav navbar-nav">
			    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
			    <li class="nav-item"><a class="nav-link" href="/src/userWork.php">Applet</a></li>
			    <li class="nav-item"><a class="nav-link" href="/src/pinManager.php">Pin manager</a></li>
        	            <?php
                            $stat = isset($_SESSION['login']) ? 'out' : 'in';
                            echo( 
                                "<li class='nav-item'>
                                    <a class='nav-link' href='/src/log{$stat}.php'>sign {$stat}</a>
                                </li>");
                            ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
