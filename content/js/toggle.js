// Toggle between expanded and small view for the task squares.
function toggleSquare(element) {
    const allSquares = document.querySelectorAll('.square');
    allSquares.forEach(square => {
        if (square !== element) {
            square.classList.remove('expanded');
            square.classList.remove('collapsing');
        }
    });
    
    if (element.classList.contains('expanded')) {
        element.classList.add('collapsing');
        element.classList.remove('expanded');

        setTimeout(() => {
            element.classList.remove('collapsing');
        }, 300); // Match the CSS transition duration
    } else {
        element.classList.add('expanded');
    }
}