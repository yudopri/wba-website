class Node {
    constructor(element) {
        this.element = element;  // form section element
        this.next = null;         // pointer to next node
        this.prev = null;         // pointer to previous node
    }
}

class DoubleLinkedList {
    constructor() {
        this.head = null;  // head of the list
        this.tail = null;  // tail of the list
        this.current = null;  // current position
    }

    add(element) {
        const newNode = new Node(element);
        if (!this.head) {
            this.head = newNode;
            this.tail = newNode;
            this.current = newNode;  // start at the head
        } else {
            this.tail.next = newNode;
            newNode.prev = this.tail;
            this.tail = newNode;
        }
    }

    moveToNext() {
        if (this.current && this.current.next) {
            this.current = this.current.next;
            return this.current.element;
        }
        return null;
    }

    moveToPrev() {
        if (this.current && this.current.prev) {
            this.current = this.current.prev;
            return this.current.element;
        }
        return null;
    }
}

const formSections = document.querySelectorAll('.form-section');
const linkedList = new DoubleLinkedList();

// Add form sections to linked list
formSections.forEach(section => {
    linkedList.add(section);
});

// Navigation buttons
const nextButton = document.getElementById('nextButton');
const prevButton = document.getElementById('prevButton');
const submitButton = document.getElementById('submitButton');

// Handle Next button click
nextButton.addEventListener('click', () => {
    const nextSection = linkedList.moveToNext();
    if (nextSection) {
        formSections.forEach(section => section.style.display = 'none');
        nextSection.style.display = 'block';
    }
});

// Handle Previous button click
prevButton.addEventListener('click', () => {
    const prevSection = linkedList.moveToPrev();
    if (prevSection) {
        formSections.forEach(section => section.style.display = 'none');
        prevSection.style.display = 'block';
    }
});

// Initially hide all sections except the first one
formSections.forEach((section, index) => {
    if (index !== 0) section.style.display = 'none';
});
