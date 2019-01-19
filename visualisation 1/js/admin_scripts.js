
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



function fallbackCopyTextToClipboard(text) {
  var textArea = document.createElement("textarea");
  textArea.value = text;
  document.body.appendChild(textArea);
  textArea.focus();
  textArea.select();

  try {
    var successful = document.execCommand('copy');
    var msg = successful ? 'successful' : 'unsuccessful';
    console.log('Fallback: Copying text command was ' + msg);
  } catch (err) {
    console.error('Fallback: Oops, unable to copy', err);
  }

  document.body.removeChild(textArea);
}
function copyTextToClipboard(text) {
  if (!navigator.clipboard) {
    fallbackCopyTextToClipboard(text);
    return;
  }
  navigator.clipboard.writeText(text).then(function() {
    console.log('Async: Copying to clipboard was successful!');
  }, function(err) {
    console.error('Async: Could not copy text: ', err);
  });
};




// Копируем текст статьи


$(".copy_article").bind("click", function(e) {
	let $this = $(this);
	
	copyTextToClipboard( $this.attr("data-content") );
	
	toastr.success("", '"' + $this.attr("data-original-title") + '" was copied to buffer' , toastrOpt); 

});


$(document).on("click", ".btn_get_payout", function(e) {


});

/*
$(document).on("click", ".in_work", function(e) {
	let $this = $(this);
	if ( $this.hasClass("off") ) {
		$this.removeClass("off").addClass("on").find("i").removeClass("fa-bell-o").addClass("fa-bell");
		//toastr.success("", 'You started work on the article!' , toastrOpt); 
	
	} else {
		$this.removeClass("on").addClass("off").find("i").removeClass("fa-bell").addClass("fa-bell-o");
		//toastr.success("", 'You have completed the article!' , toastrOpt); 
	
	};
	
	return false;
});
*/


