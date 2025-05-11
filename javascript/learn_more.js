// JavaScript to handle the arrow movement and section color change
const arrowContainer = document.querySelector('.arrow-container');
const section = document.querySelector('.intro-section');

// Function to create the smooth trailing effect
function createTrail(x, y) {
    const trail = document.createElement('div');
    trail.classList.add('arrow-trail');
    trail.style.left = `${x}px`;
    trail.style.top = `${y}px`;

    section.appendChild(trail);

    // Smoothly move the trail behind the cursor
    setTimeout(() => {
        trail.style.transition = "left 0.2s, top 0.2s"; // Faster transition for more FPS
        trail.style.left = `${x - 10}px`; // Lag effect, adjust distance
        trail.style.top = `${y - 10}px`; // Lag effect, adjust distance
    }, 10); // Small delay to create the "lag" effect

    // Remove the trail after it fades out
    setTimeout(() => {
        trail.remove();
    }, 1000); // Shorter duration for more frequent updates
}

// Optimizing mouse tracking to increase FPS using requestAnimationFrame
let lastX = 0;
let lastY = 0;

function handleMouseMove(event) {
    // Only create the trail when mouse moves, this reduces redundant updates
    const x = event.pageX;
    const y = event.pageY;

    // Create the trail with higher frequency
    if (Math.abs(lastX - x) > 5 || Math.abs(lastY - y) > 5) {
        createTrail(x, y);
    }

    lastX = x;
    lastY = y;
}

// Request animation frame for smoother and higher FPS mouse movement tracking
function startMouseTracking() {
    requestAnimationFrame(startMouseTracking);
    section.addEventListener('mousemove', handleMouseMove);
}

// Start the mouse tracking
startMouseTracking();





function buyNow() {
    alert("Redirecting to the best deals and offers page!");
    // Add actual redirect logic here if needed
}

function startQuiz() {
    alert("Starting quiz to help find your perfect phone!");
    // Add quiz functionality as desired
}

// Animate sections on scroll
window.addEventListener('scroll', () => {
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        const sectionTop = section.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;
        if (sectionTop < screenPosition) {
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }
    });
});

// Animate items on scroll
window.addEventListener('scroll', () => {
    const items = document.querySelectorAll('.feature-item, .trend-item');
    items.forEach(item => {
        const itemTop = item.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;
        if (itemTop < screenPosition) {
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }
    });
});

document.querySelectorAll('.question').forEach(question => {
    question.addEventListener('click', () => {
        const answer = question.nextElementSibling;
        answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
    });
});

// Interactive Quiz Logic
const quizQuestions = [
    {
        question: "What's your budget for a new phone?",
        options: ["Under $500", "$500-$1000", "$1000-$1500", "Above $1500"]
    },
    {
        question: "Which feature matters most?",
        options: ["Camera", "Battery Life", "Performance", "Display Quality"]
    },
    {
        question: "How important is software updates?",
        options: ["Very important", "Somewhat important", "Not too important", "Not important at all"]
    }
];

let currentQuestion = 0;

function startQuiz() {
    document.getElementById("quizContainer").style.display = "block";
    showQuestion();
}

function showQuestion() {
    const question = quizQuestions[currentQuestion];
    document.getElementById("quizQuestion").textContent = question.question;
    document.querySelectorAll(".option").forEach((btn, i) => {
        btn.textContent = question.options[i];
    });
}

function chooseOption(optionIndex) {
    // In a real app, you'd use the chosen options to suggest a phone
    // This demo simply advances to the next question
    document.getElementById("nextBtn").style.display = "inline";
}

function nextQuestion() {
    currentQuestion++;
    if (currentQuestion < quizQuestions.length) {
        showQuestion();
        document.getElementById("nextBtn").style.display = "none";
    } else {
        document.getElementById("quizResult").textContent = "Thank you for completing the quiz!";
        document.getElementById("quizResult").style.display = "block";
        document.getElementById("quizContainer").style.display = "none";
    }
}

// JavaScript for FAQ Accordion Toggle with Crazy Effect
document.querySelectorAll('.accordion-header').forEach((header) => {
    header.addEventListener('click', () => {
        const accordionItem = header.parentElement;
        const isActive = accordionItem.classList.contains('active');

        // Close all accordion items
        document.querySelectorAll('.accordion-item').forEach((item) => {
            item.classList.remove('active');
            item.querySelector('.accordion-body').classList.remove('open');
        });

        // If clicked item was not active, open it
        if (!isActive) {
            accordionItem.classList.add('active');
            accordionItem.querySelector('.accordion-body').classList.add('open');
        }
    });
});

