<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php print $docTitle?></title>

    <script type="text/javascript"  src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-1.8.2.min.js"><\/script>')</script>
    <link rel="stylesheet" type="text/css" href="js/slick/slick.css"/>
    <?php print $css?>
    <?php print $head?>
</head>

<body>
<div id="outer">
    <div id="topbar" class="clearfix">
        <?php print($boxUser) ?>
        <?php if ($languages) { ?>
            <div class="languages pull-right">
                <?php print $languages; ?>
            </div>
        <?php }?>
        <?php if ($metanavigation) { ?>
            <div class="metanavigation pull-right visible-tablet visible-desktop">
                <?php print $metanavigation; ?>
            </div>
        <?php }?>
    </div>

    <div class="clearfix container-fluid">
        <div id="header" class="row-fluid clearfix">
            <div class="col-md-12 visible-tablet visible-desktop">
                <h1><a href="<?php print GLZ_HOST; ?>" id="site-link" class="pull-left"><?php print $siteTitle; ?></a></h1>
                <?php print $search; ?>
                <div class="content-navbar">
                    <button data-target="#nav-collapse" data-toggle="collapse" class="navbar-toggle btn btn-default" type="button">
                        <i class="fa fa-align-justify"></i>
                    </button>

                    <div id="nav-collapse" class="collapse navbar-collapse">
                        <div class="menu clearfix">
                            <?php print $mainNav; ?>
                        </div>
                     </div>
                </div>
            </div>
        </div>

         <div class="content-box row-fluid clearfix">
            <?php
                $contentCssClass = 'col-md-12';
                if ($leftNav || $leftContent) {
                    $contentCssClass = 'col-md-9';
            ?>
            <div class="side-sx col-md-3">
                <div class="content-navbar">
                    <button data-target="#nav-collapse2" data-toggle="collapse" class="navbar-toggle btn btn-default" type="button">
                            <i class="fa fa-align-justify"></i>
                    </button>
                    <div id="nav-collapse2" class="collapse navbar-collapse">
                        <div class="menu clearfix">
                            <?php print $leftNav; ?>
                        </div>
                    </div>
                </div>
                <?php print $leftContent; ?>
            </div>
            <?php } ?>

            <div class="main-content <?php print $contentCssClass; ?>">
                <div class="content-box row-fluid clearfix">
                    <?php if ($breadcrumbs) { ?>
                        <div class="breadcrumb">
                            <?php print $breadcrumbs; ?>
                        </div>
                    <?php } ?>
                    <?php if ($pageTitle) { ?>
                    <div class="box-title clearfix">
                        <?php print $pageTitle; ?>
                        <?php if (__Config::get('glizycms.print.enabled')) { ?>
                            <a href="javascript:window.print()" class="print-ico"><i class="fa fa-print icon-grey"></i></a>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <?php print $content; ?>
                    <?php if ($afterContent) { ?>
                        <div class="afterContent clearfix">
                            <?php print $afterContent; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if ($sharing) { ?>
            <div class="social-channel clearfix container">
                <div class="block-share pull-right">
                    <?php print $sharing; ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<div id="footer">
    <div class="clearfix">
        <div class="container-fluid">
            <div class="col-md-4">
                <?php print $address;?>
            </div>
            <div class="col-md-4 pull-right">
                <?php if ($logoFooter) { ?>
                <div class="logo-footer">
                    <?php print $logoFooter; ?>
                </div>
                <?php } ?>
                <div class="logo-footer">
                    <a href="http://www.minervaeurope.org/structure/workinggroups/userneeds/prototipo/museoweb.html" title="<? print __T('MW_EXTERNALLINK_MAIN_PAGE');?>Museo &amp; Web" >
                        <img src="../../img/logo_museoWeb.gif" alt="Museo &amp; Web" width="50" height="50"/>
                    </a>
                </div>
                <div class="logo-footer">
                    <a href="http://www.minervaeurope.org" title="<? print __T('MW_EXTERNALLINK_MAIN_PAGE');?>Minerva Europe">
                        <img src="../../img/logo_minerva.gif" alt="Minerva Europe" width="58" height="50"/>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="info-page" class="visible-desktop">
        <div class="container-fluid">
            <?php print $linkFooter;?>
            <p class="pull-left"><?php print $copyright;?></p>
            <p class="pull-right"><?php print $docUpdate;?></p>
        </div>
    </div>
</div>

<script src="js/bootstrap.min.js"></script>
<script src="js/slick/slick.min.js"></script>
<script src="js/main.js"></script>
<?php print $tail; ?>
</body>
</html>