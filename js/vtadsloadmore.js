jQuery(document).ready(function(){
    jQuery('#load-more').click(function(){
        callForRecords();

    });
    if(vtads_loadmore_params.current_page == 1) {
        callForRecords();
    }
});

function callForRecords() {
    var button = jQuery('#load-more'),
        data = {
            'action': 'loadmore',
            'query': vtads_loadmore_params.posts, // that's how we get params from wp_localize_script() function
            'page' : vtads_loadmore_params.current_page
        };

    jQuery.ajax({ // you can also use $.post here
        url : vtads_loadmore_params.ajaxurl, // AJAX handler
        data : data,
        type : 'POST',
        beforeSend : function ( xhr ) {
            button.text('Loading...'); // change the button text, you can also add a preloader image
        },
        success : function( data ){
            if (data) {
                button.text('More records');
                // Insert new records
                let records = jQuery.parseJSON(data);
                jQuery.each(records, function(key, item)
                {
                    let itemContent = '<li class="vtads-item">';
                    itemContent += '<img src="' + item.filename + '" class="vtads-item-image" />';
                    itemContent += '<div class="vtads-item-title"><a href="/ad?ad=' + item.slug + '">' + item.title + '</a></div>';
                    itemContent += '<div class="vtads-item-price">' + item.price + ' RON</div>';
                    itemContent += '</li>';

                    jQuery("#vtads-form-list").append(itemContent);
                });

                if (vtads_loadmore_params.current_page >= vtads_loadmore_params.max_page) {
                    button.remove(); // if last page, remove the button
                }

                vtads_loadmore_params.current_page++;
            } else {
                button.remove(); // if no data, remove the button as well
            }
        }
    });
}