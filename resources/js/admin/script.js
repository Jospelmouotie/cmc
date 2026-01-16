$(document).ready(function(){
	/* This code is executed after the DOM has been completely loaded */

	/* Changing thedefault easing effect - will affect the slideUp/slideDown methods: */
	$.easing.def = "easeOutBounce";

	/* Binding a click event handler to the links: */
	$('li.button a').click(function(e){
	
		/* Finding the drop down list that corresponds to the current section: */
		var dropDown = $(this).parent().next();
		
		/* Closing all other drop down sections, except the current one */
		$('.dropdown').not(dropDown).slideUp('slow');
		dropDown.slideToggle('slow');
		
		/* Preventing the default event (which would be to navigate the browser to the link's address) */
		e.preventDefault();
	})

    $(".se-pre-con").fadeOut("slow");
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
    $(".dropdown").hover(
        function () {
            $('.dropdown-menu', this).stop(true, true).slideDown("fast");
            $(this).toggleClass('open');
        },
        function () {
            $('.dropdown-menu', this).stop(true, true).slideUp("fast");
            $(this).toggleClass('open');
        }
    );

    new FroalaEditor('textarea#froala-editor', {
        quickInsertButtons: ['image', 'table', 'ol', 'ul', 'myButton'],
        pluginsEnabled: ['quickInsert', 'image', 'table', 'lists'],
        // toolbarButtons: ['getPDF'],
        height: 300
    })
    new FroalaEditor('textarea#froala-editor1', {
        quickInsertButtons: ['image', 'table', 'ol', 'ul', 'myButton'],
        pluginsEnabled: ['quickInsert', 'image', 'table', 'lists'],
        // toolbarButtons: ['getPDF'],
        height: 300
    });


});

