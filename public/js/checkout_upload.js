jQuery( function($) {
    if (typeof checkout_uploads_params === 'undefined') {
        return false;
    }

    $('form.checkout').on( 'change', 'input[type=file]', function() {
        const files = $(this).prop('files');
        const email = $('input#billing_email').val();
        var clicked = $(this);
        var clickedParent = clicked.closest('p.form-row');
        var label = clickedParent.find('.anony-checkout-upload-label');

        if ( files.length ) {
            const file = files[0];
            const maxSize = $(this).data('max_size');
            const formData = new FormData();
            formData.append( 'uploads', file );
            formData.append( 'email', email );
            formData.append( 'input_id', $( this ).attr( 'id' ) );
            formData.append( 'data_label', $( this ).data( 'label' ) );

            if ( maxSize > 0 && file.size > ( maxSize * 1024 ) ) {
                const maxSizeText = 'This file is to heavy (' + parseInt(file.size / 1024) + ' ko)';
                clickedParent.find( '.upload-response' ).html( maxSizeText ).css('color','red').fadeIn().delay(2000).fadeOut();
                return;
            }
            $('form.checkout').block({message: null, overlayCSS:{background:"#fff",opacity: .6}});

            $.ajax({
                url: checkout_uploads_params.ajax_url,
                type: 'POST',
                data: formData,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function ( response ) {
                    $('form.checkout').unblock();
                    if ( 'success' === response.status ) {
                        label.find( '.anony-upload-lable-text' ).text( file.name );
                        label.find( '.anony-success-icon' ).css( 'opacity', '1' );
                        label.find( '.anony-failure-icon' ).css( 'opacity', '0' );
                    } else {
                        label.find( '.anony-upload-lable-text' ).text( $( this ).data( 'label' ) );
                        label.find( '.anony-success-icon' ).css( 'opacity', '0' );
                        label.find( '.anony-failure-icon' ).css( 'opacity', '1' );
                    }
                    
                },
                error: function ( error ) {
                    $('form.checkout').unblock();
                    label.find( '.anony-upload-lable-text' ).text( $( this ).data( 'label' ) );
                    label.find( '.anony-success-icon' ).css( 'opacity', '0' );
                    label.find( '.anony-failure-icon' ).css( 'opacity', '1' );
                }
            });
        }
    });
});