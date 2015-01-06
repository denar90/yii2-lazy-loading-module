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

	//remove item event
	$('.js-lazy-content').on('click', '.js-remove-item', function(event) {
		event.preventDefault();
		var removeUrl = $(this).attr('href'),
			$itemElement = $(this).closest('.js-item-container');
		$.ajax({
			url: removeUrl,
			type: 'GET',
			success: function () {
				$itemElement.remove();
			}
		});
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

		Handlebars.registerHelper('imageurl', function(images) {
			currentImageObject = images[0];
			if (currentImageObject) {
				return imagePath + currentImageObject.path + 'small_' + currentImageObject.name;
			} else {
				return false;
			}
		});

		Handlebars.registerHelper('ifCond', function(value1, value2, options) {
			if(value1 === value2) {
				return options.fn(this);
			}
			return options.inverse(this);
		});

		switch(data.additionalData.mode) {
			case 'list':
				break;
			case 'view':
				Handlebars.registerHelper('viewUrl', function(additionalData) {
					var link = additionalData.urls.viewItem + '?id=' + this.id;
					return link;
				});
				break;
			case 'edit':
				Handlebars.registerHelper('viewUrl', function(additionalData) {
					var link = additionalData.urls.viewItem + '?id=' + this.id;
					return link;
				});
				Handlebars.registerHelper('removeUrl', function(additionalData) {
					var link = additionalData.urls.removeItem + '?id=' + this.id;
					return link;
				});
				break;
		}

		$('.js-lazy-content').append(template(data));
	}
};
