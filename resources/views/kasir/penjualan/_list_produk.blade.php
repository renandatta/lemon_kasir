@foreach($produk as $key => $value)
    <div class="col-4 px-1">
        <div class="card mb-2 col-produk" onclick="tambahkan_detail({{ $value }})">
            <div class="card-body p-2" style="min-height: 80px">
                <p class=" mb-0">{{ $value->nama }}</p>
                <p class="text-right mb-0" style="position: absolute; bottom: 7px; right: 7px;"><b>{{ format_number($value->harga) }}</b></p>
            </div>
        </div>
    </div>
@endforeach
<script>
    $(".col-produk").click(function (e) {

        // Remove any old one
        $(".ripple").remove();

        // Setup
        let posX = $(this).offset().left,
            posY = $(this).offset().top,
            buttonWidth = $(this).width(),
            buttonHeight =  $(this).height();

        // Add the element
        $(this).prepend("<span class='ripple'></span>");


        // Make it round!
        if(buttonWidth >= buttonHeight) {
            buttonHeight = buttonWidth;
        } else {
            buttonWidth = buttonHeight;
        }

        // Get the center of the element
        let x = e.pageX - posX - buttonWidth / 2;
        let y = e.pageY - posY - buttonHeight / 2;


        // Add the ripples CSS and start the animation
        $(".ripple").css({
            width: buttonWidth,
            height: buttonHeight,
            top: y + 'px',
            left: x + 'px'
        }).addClass("rippleEffect");
    });
</script>
