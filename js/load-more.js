
jQuery(function($){
	let page = 2;
	const { query, url } = infinite_scroll_settings;
	const { max_num_pages: total } = query;
	const $loaderEl = $('#infinite-scroll_loader > svg');
	$loaderEl.hide();

	$(window).scroll(function () {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            if (page > total) {
                return false;
            }
            loadArticle(page);
            page++;
        }
    });

	function loadArticle(page) {
		$loaderEl.show();
		var data = {
			action: 'infinite_scroll',
			page,
			query,
		};
		$.post(url, data, function(response) {
			if(response.success) {
				$loaderEl.hide(1000);
				$('#books').append(response.data)
				page++;
			} 
		})
	};
		
});