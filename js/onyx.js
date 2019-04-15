function hoverParent(hovered_id) {

    const parent = hovered_id;

    var children = document.getElementsByClassName(parent + "-child");
    var i;
    for (i = 0; i < children.length; i++) {
        console.log(children[i].id);
        children[i].classList.remove("inactive");
        children[i].classList.add("active");
    }
}

function parentMouseOut(hovered_id) {
    const parent = hovered_id;

    var children = document.getElementsByClassName(parent + "-child");
    var i;
    for (i = 0; i < children.length; i++) {
        console.log(children[i].id);
        children[i].classList.remove("active");
        children[i].classList.add("inactive");

    }
}
