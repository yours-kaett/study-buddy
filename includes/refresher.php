<div id="refresh" class="shadow">
    <div class="spinner-border" style="width: 1.4rem; height: 1.4rem;" role="status">
        <span class="visually-hidden"> Loading...</span>
    </div>
</div>

<script>
    let startY;
    let endY;
    let loader = document.getElementById("refresh");
    let swipeInProgress = false;

    document.addEventListener("touchstart", function(e) {
        startY = e.touches[0].clientY;
        swipeInProgress = false;
    });

    document.addEventListener("touchmove", function(e) {
        endY = e.touches[0].clientY;

        let deltaY = endY - startY;

        let swipeThreshold = 100;

        if (deltaY >= swipeThreshold) {
            swipeInProgress = true;
        }

        if (swipeInProgress) {
            e.preventDefault();
            loader.style.display = "flex";
        }
    });

    document.addEventListener("touchend", function(e) {
        var deltaY = endY - startY;

        var swipeThreshold = 100;

        if (swipeInProgress && deltaY >= swipeThreshold) {
            setTimeout(function() {
                loader.style.display = "none";
                swipeInProgress = false;

                location.reload();
            }, 1000);
        } else {
            loader.style.display = "none";
            swipeInProgress = false;
        }
    });
</script>