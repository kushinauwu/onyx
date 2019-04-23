function hoverParent(hovered_id) {

    const parent = hovered_id;

    var children = document.getElementsByClassName(parent + "-child");
    var i;
    for (i = 0; i < children.length; i++) {
        children[i].classList.remove("inactive");
        children[i].classList.add("active");
    }
}

function parentMouseOut(hovered_id) {
    const parent = hovered_id;

    var children = document.getElementsByClassName(parent + "-child");
    var i;
    for (i = 0; i < children.length; i++) {
        children[i].classList.remove("active");
        children[i].classList.add("inactive");

    }
}

function logo_active(hovered_link) {
    const link = hovered_link;
    if (link === 'facebook') {
        document.getElementById('facebook-logo').src = "lib/img/facebook_inactive.jpg";
    }
}
