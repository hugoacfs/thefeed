<?php
if (!defined('CONFIG_PROTECTION')) {
    header('HTTP/1.0 403 Forbidden', true, 403);
    http_response_code(403);
    exit;
}
// DEFAULTS
$params = [];
$s_id = $_GET['sourceid'] ?? false;
if ($s_id) $params['sourceid'] = $s_id;
$params['max'] = $_GET['max'] ?? 100;
$params['page'] = $_GET['page'] ?? 1;
function buildGetString(array $params): string
{
    $pa = [];
    foreach ($params as $key => $param) {
        $pa[] = $key . '=' . $param;
    }
    $parmastring = join('&', $pa);
    return $parmastring;
}
?>
<div class="col-xs-12 col-sm-12 col-lg-12">
    <nav>
        <ol class="breadcrumb bg-dark text-light">
            <li class="breadcrumb-item ">
                <a href="admin.php">Admin</a>
            </li>
            <li class="breadcrumb-item active text-light">
                Articles
            </li>
            <div class="dropdown ml-auto ">
                <span>Showing: </span>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if ($params['max'] != 0) echo $params['max'];
                    else echo 'All'; ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php
                    $options = [25, 50, 100];
                    $tparams = $params;
                    foreach ($options as $option) {
                        $tparams['max'] = $option;
                        $string = buildGetString($tparams);
                        echo '<a class="dropdown-item" href="admin.php?table=articles&' . $string . '">' . $option . '</a>';
                    }
                    $tparams['max'] = 0;
                    $string = buildGetString($tparams);
                    echo '<a class="dropdown-item" value="All" href="admin.php?table=articles&' . $string . '">All</a>';
                    ?>
                </div>
            </div>
        </ol>
    </nav>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text text-light bg-dark" id="basic-addon1">Search</span>
        </div>
        <input id="search-area-admin" type="text" class="form-control text-light bg-dark search-me" placeholder="Example: chiuni" aria-label="Search">
    </div>
    <div class="table-responsive" style="max-height: 65vh;">
        <table class="table table-dark tableFixHead table-striped table-sm rounded" data-sortable>
            <thead>
                <tr>
                    <th class="align-top" scope="col" <?php if (!isset($_GET['sourceid'])) echo 'colspan="2"'; ?>>Source Reference</th>
                    <th class="align-top" scope="col">Source Name</th>
                    <th class="align-top" scope="col">Type</th>
                    <th class="align-top" scope="col">Source Status</th>
                    <th class="align-top" scope="col">Body</th>
                    <th class="align-top" scope="col">Creation Date</th>
                    <th class="align-top" scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $articles = $DB->fetchAllArticlesAndSources($params['page'], $params['max'], $s_id);
                $count = 0;
                foreach ($articles as $article) {
                    $count += 1;
                    $id = $article['id'];
                    $sourceid = $article['sourceid'];
                    $reference = $article['reference'];
                    $body = $article['body'];
                    $creationdate = $article['creationdate'];
                    $screenname = $article['screenname'];
                    $type = $article['type'];
                    $status = $article['status'];
                    $quickAction = 'delete-article';
                    $btnStyle = 'class="btn btn-danger mr-1"><i class="fas fa-trash"></i></button>';
                    $confirmMessage = "'Are you sure you want to permanently delete this article from the database?'";
                    $tparams = $params;
                    $tparams['sourceid'] = $sourceid;
                    $string = buildGetString($tparams);
                    echo '<tr id="row-' . $id . '">';
                    if (!isset($_GET['sourceid'])) echo '<td><a href="admin.php?table=articles&' . $string . '"><i class="fas fa-table fa-lg"></i></a></td>';
                    echo '<td class="reference">' . $reference . '</td>';
                    echo '<td class="screenname">' . $screenname . '</td>';
                    echo '<td class="type">' . ucfirst($type) . '</td>';
                    echo '<td class="type">' . ucfirst($status) . '</td>';
                    echo '<td class="status">' . $body . '</td>';
                    echo '<td class="status">' . timeago($creationdate) . '</td>';
                    echo '<td style="text-align:center;">';
                    echo '<form class="button-form" method="POST" action="admin.php?table=articles">';
                    echo '<div class="form-group hidden d-none"><input type="hidden" class="form-control" name="id" value="' . $id . '"></div>';
                    echo '<div class="form-group hidden d-none"><input type="hidden" class="form-control" name="action" value="' . $quickAction . '"></div>';
                    echo '<button value="' . $id . '" onclick="return confirm(' . $confirmMessage . ');" type="submit" ' . $btnStyle;
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>

            </tbody>
        </table>
    </div>
    <hr>
    <div class="row" <?php if ($params['max'] == 0) echo 'style="display: none;"'; ?>>
        <div class="btn-group btn-group " role="group">
            <?php
            $tparams = $params;
            $tparams['page'] = 1;
            unset($tparams['sourceid']);
            $string = buildGetString($tparams);
            ?>
            <a class="btn btn-primary" href="admin.php?table=articles&<?php echo $string; ?> ">
                <button class=" btn btn-primary" tabindex="-1">
                    <i class="fas fa-step-backward"></i>
                    Back to start
                </button>
            </a>
        </div>
        <nav class="ml-auto mr-auto">
            <ul class="pagination">
                <?php
                $pages = [($params['page'] - 2), ($params['page'] - 1), ($params['page']), ($params['page'] + 1), ($params['page'] + 2)];
                $tparams = $params;
                foreach ($pages as $page) {
                    $disabled = '';
                    $active = '';
                    if ($page < 1) {
                        $disabled = 'disabled';
                        continue;
                    }
                    if ($page === $params['page']) $active = 'active';
                    $tparams['page'] = $page;
                    $string = buildGetString($tparams);
                    echo '<li class="page-item ' . $active . ' ' . $disabled . '">
                              <a class="page-link" href="admin.php?table=articles&' . $string . '" tabindex="-1">' . $page . '</a>
                          </li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</div>