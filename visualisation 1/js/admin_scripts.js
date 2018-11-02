
function render_cell_article_title( data, type, row, meta ) {
	if (type == "display") {
		return "<span><a style='padding: 0 10px 0 0 ' href='"+ data.url + "' target='_blank'><i class='fa-external-link'></i></a>"+ data.text +"</span>";
	} else return data.text;
};

function render_cell_url( data, type, row, meta ) {
	if (type == "display") {
		return "<a style='' href='"+ data.url + "' target='_blank'>"+ data.text +"</a>";
	} else return data.text;
};



$(document).on("click", ".btn_get_payout", function(e) {


});


