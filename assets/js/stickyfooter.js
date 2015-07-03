/**
 * javascript solution to the classic sticky footer problem
 * The footer doesn't have a static height so a purely CSS solution will
 * not solve the problem by itself.
 * author: Todd Miller <todd@rainydaymedia.net>
 */

// dynamically set the bottom padding if the user resizes the window
( function () {
    var afixFooter = function() {
        $content.style.paddingBottom = $footer.clientHeight + 'px';
    },
    $content = document.getElementById('page'),
    $footer  = document.getElementById('colophon'),
    // start out true here so the footer gets updated after the page loads
    didResize = true;

    afixFooter();

    window.addEventListener('resize', function () {
        didResize = true;
    });

    setInterval(function() {
        if (didResize) {
            didResize = false;
            afixFooter();
        }
    }, 250);
})();
