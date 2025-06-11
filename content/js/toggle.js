function toggleSquare(element) {
    const allSquares = document.querySelectorAll('.square');
    allSquares.forEach(square => {
        if (square !== element) {
            square.classList.remove('expanded');
        }
    });
    element.classList.toggle('expanded');
}