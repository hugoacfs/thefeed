<?php
if (!defined('CONFIG_PROTECTION')) {
    header('HTTP/1.0 403 Forbidden', true, 403);
    http_response_code(403);
    exit;
}
?>
<div class="col-xs-12 col-sm-12 col-lg-12 ">
    <nav>
        <ol class="breadcrumb bg-dark text-light">
            <li class="breadcrumb-item ">
                <a href="admin.php">Admin</a>
            </li>
            <li id="sources-page" class="breadcrumb-item active text-light">
                Sources
            </li>
        </ol>
    </nav>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text text-light bg-dark" id="basic-addon1">Search</span>
        </div>
        <input id="search-area-admin" type="text" class="form-control text-light bg-dark search-me" placeholder="Example: chiuni" aria-label="Search" aria-describedby="basic-addon1">
    </div>
    <div class="table-responsive" style="max-height: 65vh;">
        <table class="table table-dark tableFixHead table-striped " data-sortable>
            <thead>
                <tr">
                    <th scope="col" colspan="2">Reference</th>
                    <th scope="col">Screen name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Status</th>
                    <th scope="col">Update</th>
                    <th scope="col">Show/Hide</th>
                    </tr>
            </thead>
            <tbody>
                <?php
                $sources = $DB->fetchAllSources();
                $count = 0;
                foreach ($sources as $source) {
                    $count += 1;
                    $id = $source['id'];
                    $reference = $source['reference'];
                    $screenname = $source['screenname'];
                    $type = $source['type'];
                    $status = $source['status'];
                    if ($status === 'active') {
                        $quickAction = 'suspend-source';
                        $btnStyle = 'class="btn btn-success mr-1"><i class="fas fa-eye"></i></button>';
                    } else {
                        $quickAction = 'activate-source';
                        $btnStyle = 'class="btn btn-warning mr-1"><i class="fas fa-eye-slash"></i></button>';
                    }
                    echo '<tr id="row-' . $id . '">';
                    echo '<td><a href="admin.php?table=articles&sourceid=' . $id . '"><i class="fas fa-table fa-lg"></i></a></td>';
                    echo '<td class="reference">' . $reference . '</td>';
                    echo '<td class="screenname">' . $screenname . '</td>';
                    echo '<td class="type">' . ucfirst($type) . '</td>';
                    echo '<td class="status">' . ucfirst($status) . '</td>';
                    echo '<td style="text-align:center;">';
                    echo '<button data-toggle="modal" value="' . $id . '" data-target="#modal" onClick="updateSource(' . $id . ')" type="button" class="btn btn-primary mr-1"><i class="fas fa-edit"></i></button>';
                    echo '</td>';
                    echo '<td style="text-align:center;">';
                    echo '<form class="button-form" method="POST" action="admin.php?table=sources">';
                    echo '<div class="form-group hidden d-none"><input type="hidden" class="form-control" name="id" value="' . $id . '"></div>';
                    echo '<div class="form-group hidden d-none"><input type="hidden" class="form-control" name="action" value="' . $quickAction . '"></div>';
                    echo '<button value="' . $id . '" type="submit" ' . $btnStyle;
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>

            </tbody>
        </table>
    </div>
    <hr>
    <div class="btn-group btn-group " role="group">
        <button data-toggle="modal" class="add-source btn btn-success " data-target="#modal" onClick="addNewSource()" type="button">
            <i class="fas fa-plus mr-1"></i>
            Add source
        </button>
    </div>
</div>