<div id="container">
    <div id="content">
        <nav class="d-flex flex-row-reverse bd-highlight">
            <div class="float-right">
                <label><?php echo __('Sort')?>:</label>
                <select>
                    <option value="price-asc"><?php echo __('Price ascending')?></option>
                    <option value="price-desc"><?php echo __('Price descending')?></option>
                    <option value="name-asc"><?php echo __('Name ascending')?></option>
                </select>
                <span><i class="fa fa-list"></i><?php echo __('List')?></span>
                <span><i class="fa fa-table"></i><?php echo __('Grid')?></span>
            </div>
        </nav>

    <?php
        echo '<ul id="vtads-form-list">';
        echo '</ul>';
        echo '<button id="load-more">' . __('Load records') . '</button>';
    ?>
    </div>
</div>