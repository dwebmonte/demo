"use strict";

/*
	
	<input name="name" fg-label="Name" fg-label-col="" fg-separator="true"/>
	<select name="access" fg-label="Access" fg-separator="true" data-value='"admin":"admin", "writer":"writer"' value="writer"></select>
	<button fg-label="">Add user</button>
	
	
	
*/


$("[fg-label]").each(function(i, elem) {
	let $el = $(elem), html = "";
	
	let label_col_sm = 2, input_col_sm = 12 - label_col_sm;
	
	// input
	if ($el.is("input")) {

		html = `<div class="form-group">
						<label class="col-sm-${label_col_sm} control-label">`+ $el.attr("fg-label") +`</label>
						<div class="col-sm-${input_col_sm}">`+ $el.addClass("form-control").prop('outerHTML') +`</div>
					</div>`;		
		
	} else if ($el.is("textarea")) {	
		html = `<div class="form-group">
						<label class="col-sm-${label_col_sm} control-label">`+ $el.attr("fg-label") +`</label>
						<div class="col-sm-${input_col_sm}">`+ $el.addClass("form-control").prop('outerHTML') +`</div>
					</div>`;		
		
	} else if ($el.is("select")) {
		
		// если задан массив значений option
		if ($el.attr("data-value")) {
			let ar = {admin: 'admin', value: 'value'};

			let data_option = JSON.parse( '{' + $el.attr("data-value") + '}' ), html_option = "";
			for (let key in data_option) {
				if ( $el.attr("value") && $el.attr("value") == key ) html_option += `<option selected name=${key}>${data_option[key]}</option>`; 
				else html_option += `<option name=${key}>${data_option[key]}</option>`;
			};
			
			$el.html( html_option );
		}
		
		html = `<div class="form-group">
						<label class="col-sm-${label_col_sm} control-label">`+ $el.attr("fg-label") +`</label>
						<div class="col-sm-${input_col_sm}">`+ $el.addClass("form-control").prop('outerHTML') +`</div>
					</div>`;		
		
	}
	else if ($el.is("button")) {
		if ( !$el.attr("type") ) $el.attr("type", "submit");
		$el.addClass("btn btn-primary btn-single pull-right");
		
		html = `<div class="form-group"><div class="col-sm-12">`+ $el.prop('outerHTML') +`</div></div>`;		
		
	}
				
	if ( $el.attr("fg-separator")) html = html + `<div class="form-group-separator"></div>`	
				

	$el.replaceWith( html );				
});



$("[modal-id]").each(function(i, elem) {
	let $el = $(elem), modal_body = "", modal_header = "";	 
	
	
	console.info( $el.attr("modal-title") );
	if ( $el.attr("modal-title") )  {
	
		modal_header = `
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">`+ $el.attr("modal-title") +`</h4>
			</div>`;	
		$el.removeAttr("modal-title");
	};
	
	
	
	modal_body = `
		<div class="modal fade" id="${$el.attr("modal-id")}">
			<div class="modal-dialog">
				<div class="modal-content">
					`+ modal_header +`
					<div class="modal-body">`+ $el.removeAttr("modal-id").prop('outerHTML') + `</div>
				</div>
			</div>
		</div>`;
	
	$el.prop('outerHTML', modal_body);	 
	 	 
		 
});




/*
	
	<div class="modal fade" id="modal-1">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Basic Modal</h4>
				</div>
				
				<div class="modal-body">
					Hello I am a Modal!
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-info">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	
*/
