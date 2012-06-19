/*
//	I  want to start by saying THANK YOU to "Modern Tribe, Inc." for their wonderful IMAGE WIDGET plug-in
//
//	Not only has referencing that, and Modern Tribe's other brilliant work, helped me with my own plug-in,
//	but this JavaScript file in particular is absolutely based upon the JS file in IMAGE WIDGET
//
//	That will change as time moves on (I've added 2 functions in the last day), but this message will stay.
//
*/

var pwbImage;

(function($){

    pwbImage = {

        sendToEditor : function(h) {        
            // ignore content returned from media uploader and use variables passed to window instead

            //	ID of Image
            $( '#pwb-'+ self.instaceID +'-id' ).val( self.IW_img_id );  

            // display attachment preview
//            $( '#replace-' + self.instaceID ).html( self.IW_html );
            $( '#replace-' + self.instaceID ).html( '<img src="' + self.IW_url + '" />' );            

            // change width & height fields in widget to match image
			$( '#pwb-'+ self.instaceID +'-width' ).val($( '#replace-' + self.instaceID + ' img').attr('width'));
			$( '#pwb-'+ self.instaceID +'-height' ).val($( '#replace-' + self.instaceID + ' img').attr('height'));

            // set alignment in widget
            $( '#pwb-'+ self.instaceID +'-align' ).val(self.IW_align);

            // set title in widget
            $( '#pwb-'+ self.instaceID +'-title' ).val(self.IW_title);

            // set caption in widget
            $( '#pwb-'+ self.instaceID +'-caption' ).val(self.IW_caption);

            // set alt text in widget
            $( '#pwb-'+ self.instaceID +'-alt' ).val(self.IW_alt);

            // set link in widget
            $( '#pwb-'+ self.instaceID +'-url' ).val(self.IW_url);
            $( '#pwb-'+ self.instaceID +'' ).val(self.IW_url);

            // close thickbox
            tb_remove();

            // change button text
            //$('#add_image-widget-'+self.IW_instance+'-image').html($('#add_image-widget-'+self.IW_instance+'-image').html().replace(/Add Image/g, 'Change Image'));
        },

        changeImgWidth : function(instance) {
            var width = $( '#widget-'+instance+'-width' ).val();
            var height = Math.round(width / pwbImage.imgRatio(instance));
            pwbImage.changeImgSize(instance,width,height);
        },

        changeImgHeight : function(instance) {
            var height = $( '#widget-'+instance+'-height' ).val();
            var width = Math.round(height * pwbImage.imgRatio(instance));
            pwbImage.changeImgSize(instance,width,height);
        },

        imgRatio : function(instance) {
            var width_old = $( '#display-widget-'+instance+'-image img').attr('width');
            var height_old = $( '#display-widget-'+instance+'-image img').attr('height');
            var ratio =  width_old / height_old;
            return ratio;
        },

        changeImgSize : function(instance,width,height) {
            if (isNaN(width) || width < 1) {
                $( '#widget-'+instance+'-width' ).val('');
                width = 'none';
            } else {
                $( '#widget-'+instance+'-width' ).val(width);
                width = width + 'px';
            }
            $( '#display-widget-'+instance+'-image img' ).css({
                'width':width
            });

            if (isNaN(height) || height < 1) {
                $( '#widget-'+instance+'-height' ).val('');
                height = 'none';
            } else {
                $( '#widget-'+instance+'-height' ).val(height);
                height = height + 'px';
            }
            $( '#display-widget-'+instance+'-image img' ).css({
                'height':height
            });
        },

        changeImgAlign : function(instance) {
            var align = $( '#widget-'+instance+'-align' ).val();
            $( '#display-widget-'+instance+'-image img' ).attr(
                'class', (align == 'none' ? '' : 'align'+align)
            );
        },

        imgHandler : function(event) {
        	
        	self.instaceID	=	$(this).parent().attr('id');
        	
        	
            event.preventDefault();
            window.send_to_editor = pwbImage.sendToEditor;
        //    tb_show("Add an Image", event.target.href, false);
        },


        imgRemove : function(event) {
        	
        	self.instaceID	=	$(this).parent().attr('id');
        //	alert(' You want to remove: ' + self.instaceID );
        	
            $( '#pwb-'+ self.instaceID +'-id' ).val('');  

            // change width & height fields in widget to match image
			$( '#pwb-'+ self.instaceID +'-width' ).val('');
			$( '#pwb-'+ self.instaceID +'-height' ).val('');

            // set alignment in widget
            $( '#pwb-'+ self.instaceID +'-align' ).val('');

            // set title in widget
            $( '#pwb-'+ self.instaceID +'-title' ).val('');

            // set caption in widget
            $( '#pwb-'+ self.instaceID +'-caption' ).val('');

            // set alt text in widget
            $( '#pwb-'+ self.instaceID +'-alt' ).val('');

            // set link in widget
            $( '#pwb-'+ self.instaceID +'-url' ).val('');
            $( '#pwb-'+ self.instaceID +'' ).val('');        	
        		
 
            // display attachment preview
            $( '#replace-' + self.instaceID ).fadeTo(750, 0.2);


            $( this ).fadeTo(500, 0);             
			$( '#' + self.instaceID + ' span.remove-wp-image-span' ).html('You need to "Save Changes" before this image will be removed.'); 
			$( '#' + self.instaceID + ' span.remove-wp-image-span' ).fadeTo(500, 1); 

        	
            event.preventDefault();
        //   window.send_to_editor = pwbImage.sendToEditor;
        //    tb_show("Add an Image", event.target.href, false);
        },


/*
        setActiveWidget : function(instance_id) {
            self.IW_instance = instance_id;
        }
*/
/*
        setInstanceID	:	function(event)	{

			alert($(this).parent().attr('id'));	        
	        
        }*/
        

    };

/*    
    $setThisInstance.function() {
	    
    };
*/    

	$(document).ready(function() {
	
//		$("a.thickbox").click(function(e) {
//			alert($(this).html());
//		});
	

		// Use new style event handling since $.fn.live() will be deprecated
		if ( typeof $.fn.on !== 'undefined' ) {
			$("#wpbody").on("click", ".thickbox", pwbImage.imgHandler);
			$("#wpbody").on("click", ".remove-wp-image-style", pwbImage.imgRemove);			
		}
		else {
			$("a.thickbox").live('click', pwbImage.imgHandler);
			$("a.remove-wp-image-style").live('click', pwbImage.imgRemove);
		}


						

	});

})(jQuery);