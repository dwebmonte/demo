<div id="test_page_wrapper"></div>

		<!-- <form class="form-horizontal" action="gate/user/insert" method="GET"> -->
		<form class="form-horizontal" action="test" method="GET" modal-id="win_user_add" modal-title="Add user">
			<input type="hidden" name="test_add_user" value="1" />
			<input name="name" fg-label="Name" fg-label-col="" fg-separator="true"/>
			<input name="email" fg-label="Email (login)" fg-label-col="" fg-separator="true"/>
			<input name="password" fg-label="Password" fg-label-col="" fg-separator="true"/>
			<select name="access" fg-label="Access" fg-separator="true" data-value='"admin":"admin", "writer":"writer"' value="writer"></select>
			<button fg-label="">Add user</button>
		</form>	



<!--
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
-->