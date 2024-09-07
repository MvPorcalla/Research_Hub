// Sample data for suggestions
let suggestionData = [];

// Function to fetch suggestions from the server
async function fetchSuggestions(query) {
    try {
        const response = await fetch(`../../backend/searchSuggestion.php?query=${encodeURIComponent(query)}`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        suggestionData = data; // Update the suggestionData array with the fetched data
        updateSuggestionText(query); // Update suggestions after fetching
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    }
}

// Function to get suggestions based on query
function getSuggestions(query) {
    return suggestionData.filter(item => item.toLowerCase().startsWith(query.toLowerCase()));
}

// Function to update suggestion text
function updateSuggestionText(query) {
    const suggestionText = document.getElementById('suggestion-text');
    const inputField = document.getElementById('query');
    
    if (!query) {
        suggestionText.textContent = '';
        suggestionText.style.display = 'none';
        return;
    }
    
    const suggestions = getSuggestions(query);
    if (suggestions.length > 0) {
        // Use the first suggestion for demonstration
        suggestionText.textContent = suggestions[0].slice(query.length);
        suggestionText.style.display = 'block';
        const inputWidth = inputField.offsetWidth;
        const textWidth = getTextWidth(query, getComputedStyle(inputField).font);
        suggestionText.style.left = `${textWidth}px`;
    } else {
        suggestionText.textContent = '';
        suggestionText.style.display = 'none';
    }
}

// Function to calculate text width
function getTextWidth(text, font) {
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    context.font = font;
    return context.measureText(text).width;
}

// Example usage: Add event listener to input field
document.getElementById('query').addEventListener('input', (event) => {
    const query = event.target.value;
    if (query) {
        fetchSuggestions(query);
    } else {
        // Clear suggestions if query is empty
        updateSuggestionText('');
    }
});
