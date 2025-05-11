const trailContainer = document.getElementById('trail-container');
const loginContainer = document.getElementById('login-container');
const signupContainer = document.getElementById('signup-container');


function createTrailDot(x, y) {
    const dot = document.createElement('div');
    dot.classList.add('trail-dot');
    dot.style.left = `${x}px`;
    dot.style.top = `${y}px`;
    trailContainer.appendChild(dot);

    setTimeout(() => {
        dot.remove();
    }, 1500);
}

document.addEventListener('mousemove', (event) => {
    createTrailDot(event.pageX, event.pageY);
});

function showSignUp() {
    loginContainer.style.display = 'none';
    signupContainer.style.display = 'flex';
}


function showLogin() {
    signupContainer.style.display = 'none';
    loginContainer.style.display = 'flex';
}
