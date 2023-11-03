
jQuery(function($){
	let page = 2;
	let loading = false;
	const { query, url } = infinite_scroll_settings;
	const { max_num_pages: total } = query;
	const $loaderEl = $('#infinite-scroll_loader');

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
		if(!loading) {
			$loaderEl.show();
			loading = true;
			var data = {
				action: 'infinite_scroll',
				page,
				query,
			};
			console.log('post url, data', url, data);
			$.post(url, data, function(response) {
				if(response.success) {
					loading = false;
					$loaderEl.hide(1000);

					console.log('post success response', response);
					$('#books').append(response.data)
					page++;
				} else {
					// console.log(res);
				}
			}).fail(function(xhr, textStatus, e) {
				// console.log(xhr.responseText);
			});
		}
	};
		
});