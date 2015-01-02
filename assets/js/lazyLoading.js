//lazyLoading constructor
var lazyLoading = function() {
	this.limit = 10,
	this.offset = 0;

};

lazyLoading.prototype.init = function(getDataUrl) {
	var self = this,
		initedScrollListener = false,
		getDataFlag = true,
		getDataScrollFlag = true;

	//get data on init
	getData(getDataUrl);

	$('.js-get-more-items').on('click', function() {
		//increase offset and get data if flag is true
		if (getDataFlag) {
			self.offset += self.limit;
			getData(getDataUrl);
		} else {
			$(this).addClass('hide');
		}
	});

	/**
	 * Init scroll listener.
	 * @private
	 * @return void
	 */
	function initScrollListener() {
		$(window).scroll(function () {
			if ($(window).scrollTop() + $(window).height() > $(document).height() - 300) {
				//increase offset and get data if flag is true
				if (getDataScrollFlag) {
					getDataScrollFlag = false;
					self.offset += self.limit;
					getData(getDataUrl);
				}
			}
		});
	}

	/**
	 * Get items data
	 * @private
	 * @param {string} getDataUrl Url for ajax request
	 * @return void
	 */
	function getData(getDataUrl) {
		//hide get data button
		$('.js-get-more-items').addClass('hide');
		//show loader
		$('.js-loader').show();
		//@todo remove setimeout
		setTimeout(function() {
			$.ajax({
				url: getDataUrl + '?getDataFlag=' + getDataFlag + '&limit=' + self.limit + '&offset=' + self.offset,
				type: 'GET',
				success: function (data) {
					//hide loader
					$('.js-loader').hide();
					buildTemplate(data);
					//if data items less then limit, set getDataFlag into false
					if (data.items.length < self.limit) {
						getDataFlag = false;
					} else {
						if (!getDataScrollFlag) {
							$('.js-get-more-items').removeClass('hide');
						}

						//init scroll listener function after first data loading
						if (!initedScrollListener) {
							initedScrollListener = true;
							initScrollListener();
						}
					}
				}
			});
		}, 5000);
	}

	/**
	 * Build template. Using Handlebars.js
	 * @private
	 * @param {object} data Response data from serverData
	 * @return void
	 */
	function buildTemplate(data) {
		var source = $("#js-lazy-load-template").html(),
			template = Handlebars.compile(source);

		//can add Handlebars helper here

		$('.js-lazy-content').append(template(data));
	}
};
