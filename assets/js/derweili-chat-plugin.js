(function($){

    var $chatIcon = $('#derweili-fb-chat-icon'),
        $optInMessage = $('#derweili-fb-chat-opt-in-message'),
        $acceptButton = $($optInMessage).find('#accept'),
        $closeButton = $($optInMessage).find('.close'),
        $optOutLink = $('.derweili-fb-opt-out-link'),
        appId = $($optInMessage).attr('data-app-id'),
        cookieName = $($optInMessage).attr('data-cookie-name');
    console.log('cookie name', cookieName);

    console.log($chatIcon);

    $($chatIcon).on('click', function(e){
        e.preventDefault();
        $optInMessage.toggleClass('active');
    });
    $($closeButton).on('click', function(e){
        e.preventDefault();
        $optInMessage.toggleClass('active');
    });


    $($acceptButton).on('click', function(e){
        e.preventDefault();
        loadFbStuff();
        hideOptInStuff();
        setCookieOptInCookie();
    })


    function loadFbStuff(){
        console.log('loadFbStuff');
        window.fbAsyncInit = function() {
            console.log('fbAsyncInit');
            FB.init({
                appId            : appId,
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v2.12'
            });
        };
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/de_DE/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));


    }
1
    function setCookieOptInCookie()
    {
        var expires = new Date();
        expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));

        var value = 1;

        document.cookie = cookieName + '=' + value +';path=/'+ ';expires=' + expires.toUTCString();
    }

    function hideOptInStuff(){
        $optInMessage.fadeOut('200');
        $chatIcon.fadeOut('200');
    }

    // opt out link
    $optOutLink.on('click', function(e){
        console.log('opt-out');

        var cookieName = $(this).attr('data-cookie-name');

        e.preventDefault();

        var expires = new Date();
        expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));

        var value = 0;

        document.cookie = cookieName + '=' + value +';path=/'+ ';expires=' + expires.toUTCString();
    });






})(jQuery);
