<?php
if (!defined('CONFIG_PROTECTION')) {
    header('HTTP/1.0 403 Forbidden', true, 403);
    http_response_code(403);
    exit;
}
function displayHomeLink($pageId)
{
    if ($pageId === 'home') {
        $status = 'active';
    } else {
        $status = '';
    }
    echo '<li title="Home link." class="nav-item ">
                <a class="nav nav-link ' . $status . ' ml-auto" href="index.php">
                    <i class="fas fa-home">
                    </i> Home
                </a>
            </li>';
}
function displayPagesBtn()
{
    // <span class="fas fa-th-list menu-fa"></span> alternative
    echo '<button id="pages-btn" type="button" class="btn btn-outline-light mr-1 ml-1" data-toggle="modal" data-target="#pagesModal">
            <span class="fas fa-at menu-fa"></span> 
            <span class="preferences-btn-text">Pages</span>
          </button>';
}
function displayTopicsBtn()
{
    echo '<button id="topics-btn" type="button" class="btn btn-outline-light mr-1 ml-1" data-toggle="modal" data-target="#topicsModal">
            <span class="menu-fa fas fa-hashtag"></span> 
            <span class="preferences-btn-text">Topics</span>
          </button>';
}
function displayMyTimelineLink($pageId)
{
    if (!isLoggedIn()) {
        $status = 'disabled';
    } elseif ($pageId === 'timeline') {
        $status = 'active';
    } else {
        $status = '';
    }
    echo '<li class="nav-item ">
                <a class="nav-link ' . $status . '" href="timeline.php"><i class="fas fa-stream">
                    </i> My Timeline
                </a>
            </li>';
}
function displayAdminLink($pageId)
{
    if (!isLoggedIn()) {
        $status = 'disabled';
    } elseif ($pageId === 'admin') {
        $status = 'active';
    } else {
        $status = '';
    }
    echo '<li class="nav-item ">
                <a class="nav-link ' . $status . '" href="admin.php"><i class="fas fa-users-cog">
                    </i> Admin
                </a>
            </li>';
}
function displayLoginLink($pageId)
{  
    $status = '';
    if (!isLoggedIn()) {
        $url = 'login.php';
        $text = 'Login';
        if($pageId === 'login'){
            $status = 'active';
        }
    } else {
        $url = 'logout.php';
        if (isset($_SESSION['logout_url'])) {
            $url = $_SESSION['logout_url'];
        }
        $text = 'Logout';
    }
    echo '<li class="nav-item ' . $status . '">
                <a class="nav-link " href="' . $url . '"><i class="fas fa-sign-out-alt">
                    </i> ' . $text . '
                </a>
            </li>';
}
function displayAboutLink($pageId)
{
    $status = '';
    if (isLoggedIn()) {
        if ($pageId === 'about') {
            $status = 'active';
        }
        $url = 'about.php';
        $text = 'About';
        echo '<li class="nav-item ">
                <a class="nav-link ' . $status . '" href="' . $url . '"><i class="fas fa-info-circle">
                    </i> ' . $text . '
                </a>
            </li>';
    }
}
function displayFeedbackLink($pageId)
{
    $status = '';
    if (isLoggedIn()) {
        if ($pageId === 'feedback') {
            $status = 'active';
        }
        $url = 'feedback.php';
        $text = 'Feedback';
        echo '<li class="nav-item ">
                <a class="nav-link ' . $status . '" href="' . $url . '"><i class="fas fa-comments">
                    </i> ' . $text . '
                </a>
            </li>';
    }
}
?>
<body class="no-gutters pb-0 overflow-hidden">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark justify-content-end mynav">
        <a class="navbar-brand mr-auto" href="#">
            <img class="navbar-logo" src="img/nav_logo.png" alt="University of Chichester News">
            uoc news
        </a>
        <?php
        if (isLoggedIn() && $pageId === 'timeline') {
            displayPagesBtn();
            displayTopicsBtn();
        }
        ?>
        <button class="navbar-toggler btn btn-outline-light mr-1 ml-1 align-items-center" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="menu-fa burger fas fa-bars align-items-center"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto">
                <?php
                displayHomeLink($pageId);
                displayMyTimelineLink($pageId);
                if (isAdminLoggedIn()) {
                    displayAdminLink($pageId);
                }
                // displayAboutLink($pageId);
                displayFeedbackLink($pageId);
                displayLoginLink($pageId);
                ?>
            </ul>
        </div>
    </nav>