$(document).ready(function() {
	$('.hed-tit+ul').each(function(ind, obj) {
		$(obj).css('top', -$(obj).height());
	});
	iele = document.createElement('span');
	iele.className = 'cani';
	$('a').on('click', function() {
		$(this).append(iele);
		size = Math.max($(this).width(), $(this).height());
		$(this).children('.cani').css({
			'top': event.offsetY - size / 2,
			'left': event.offsetX - size / 2,
			'width': size,
			'height': size,
			'animation-play-state': 'paused'
		});
		$(this).children('.cani').css('animation-play-state', 'running');
	});
	$('#draw-but').on('click', function() {
		event.preventDefault();
		if($(this).next('ul').css('width') == '0px') {
			$(this).next('ul').css({
				'height': 'calc(100vh - 19.4vw)',
				'width': '94.6vw',
				'bottom': '2.7vw',
				'left': '2.7vw',
			});
			$(this).removeClass('fa-bars');
			$(this).addClass('fa-times');
		} else {
			$(this).next('ul').css({
				'height': '0',
				'width': '0',
				'bottom': '14vw',
				'left': '50vw'
			});
			$(this).removeClass('fa-times');
			$(this).addClass('fa-bars');
		}
	});
});