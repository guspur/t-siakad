//$('#result').html("Isi data di form di bawah ini").fadeOut(2000);

$('#form').submit(function() {
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				alert(data);
				$('input#text').attr('value','');
			}
		})
		return false;
	});
