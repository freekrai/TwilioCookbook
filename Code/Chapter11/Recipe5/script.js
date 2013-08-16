$(document).ready(function() {
	$.ajaxSetup({ cache: false });

	daemon();

	$(".123btn").on('click',function(e){
		var img = $(this).data("img");
		$('#mimg').attr("src",img);
		$('#himg').val( img );
		$('#myModal').modal('show');
		e.preventDefault();
		return false;
	});
});
function daemon() {
	$.get("index.php",function(result){
		var cacheDom = $(".polaroids").html();
		if(result !=  cacheDom ){
			$(".polaroids").fadeOut().html(result).fadeIn();
		}
		setTimeout(daemon, 10000);
	});
}
