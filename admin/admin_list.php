

<table class="wp-list-table widefat fixed striped table-view-list posts">
		<caption class="screen-reader-text">Table ordered by Date. Descending.</caption>
    <thead>
        <tr>
            <td id="cb" class="manage-column column-cb check-column"><input id="cb-select-all-1" type="checkbox">
			    <label for="cb-select-all-1"><span class="screen-reader-text">Select All</span></label>
            </td>
            <th scope="col" id="title" class="manage-column column-title column-primary sortable desc" abbr="Title">
                <a href="http://192.168.1.9/wp-admin/edit.php?orderby=title&amp;order=asc">
                    <span>Title</span>
                    <span class="sorting-indicators">
                        <span class="sorting-indicator asc" aria-hidden="true"></span>
                        <span class="sorting-indicator desc" aria-hidden="true"></span>
                    </span>
                    <span class="screen-reader-text">Sort ascending.</span>
                </a>
            </th>
            <th scope="col" id="categories" class="manage-column column-categories">Categories</th>
            <th scope="col" id="tags" class="manage-column column-tags">Date created</th>
        </tr>
	</thead>
	<tbody id="the-list">
    <?php
        foreach ($records as $record) {
    ?>
        <tr id="post-1" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
            <th scope="row" class="check-column">
                <input id="cb-select-1" type="checkbox" name="post[]" value="<?php echo $record->id; ?>">
                <label for="cb-select-1">
                    <span class="screen-reader-text">Select <?php echo $record->title; ?></span>
                </label>
            </th>
            <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                <strong><a class="row-title" href="/wp-admin/admin.php?page=vt-classified-ads&ad=<?php echo $record->id; ?>&action=edit" aria-label="<?php echo $record->title; ?>"><?php echo $record->title; ?></a></strong>

            </td>
            <td class="date column-date" data-colname="Category"></td>
            <td class="date column-date" data-colname="Date">Published<br><?php echo $record->created_at; ?></td>
            <td class="manage-column column-approval" data-colname="Actions">
                <a href="/wp-admin/admin.php?page=vt-classified-ads&ad=<?php echo $record->id; ?>&action=approve">Approve</a> |
                <a href="/wp-admin/admin.php?page=vt-classified-ads&ad=<?php echo $record->id; ?>&action=edit">Edit</a>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
	<tfoot>
	<tr>
		<td class="manage-column column-cb check-column"><input id="cb-select-all-2" type="checkbox">
			<label for="cb-select-all-2"><span class="screen-reader-text">Select All</span></label>
        </td>
        <th scope="col" class="manage-column column-title column-primary sortable desc" abbr="Title">
            <a href="http://192.168.1.9/wp-admin/edit.php?orderby=title&amp;order=asc">
                <span>Title</span>
                <span class="sorting-indicators">
                    <span class="sorting-indicator asc" aria-hidden="true"></span>
                    <span class="sorting-indicator desc" aria-hidden="true"></span>
                </span>
                <span class="screen-reader-text">Sort ascending.</span>
            </a>
        </th>
        <th scope="col" class="manage-column column-categories">
            Categories
        </th>
        <th scope="col" class="manage-column column-tags">
            Tags
        </th>
    </tr>
	</tfoot>

</table>