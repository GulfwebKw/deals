// function ShowValidationError(object){
// 	 for (var key in object) {
//       if (object.hasOwnProperty(key)) {
//         var val = object[key];
//         $('#'+key).after(`<label id="${key}-error" class="error" for="${key}">${val}</label>`);
//       }
//     }
// }
function alertMessage(type,title,message){
	var btnclass = '';
	switch (type){
		case 'success':
			btnclass = 'btn-success';
			break;
		case 'error':
			btnclass = 'btn-danger';
			break;	
		case 'info':
			btnclass = 'btn-info';
			break;	
		default:
		 btnclass = 'btn-info';
		break;
	}
	swal({
            type: type,
            title: title,
            text: message,
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-lg '+btnclass
     });
}
/*
*function destroy jquery form validation
*/
 // function distroyValidation(form_id){
 //      var $alertas = $('#'+form_id);
 //      $alertas.validate().resetForm();
 //      $alertas.find('.error').removeClass('error');
 //      $alertas.validate().destroy();
 // }
 
 // code for all select or deselect
  /*$('#select_all').click(function(){
      if(this.checked){
        $('.select-related-id').prop('checked',true);
      }else{
        $('.select-related-id').prop('checked',false);
      }
  });

  $(document).on('click','.select-related-id',function(){
      if($('#select_all').is(':checked') && !this.checked){
        $('#select_all').prop('checked',false);
      }
      else if($('.select-related-id').length == $('.select-related-id:checked').length){
        $('#select_all').prop('checked',true);
      }
  });*/