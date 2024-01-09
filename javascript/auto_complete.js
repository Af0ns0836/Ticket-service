
let suggestions = ["Apple", "Banana", "Cherry", "Durian", "Elderberry", "Fig", "Grape", "Honeydew", "Iced Melon", "Jackfruit", "Kiwi", "Lemon", "Mango", "Nectarine", "Orange", "Papaya", "Quince", "Raspberry", "Strawberry", "Tangerine", "Ugli Fruit", "Vanilla Bean", "Watermelon", "Xigua", "Yellow Watermelon", "Zucchini","Zebra"];

    let input = document.getElementById("autocomplete");
    let container = document.createElement("div");
    container.setAttribute("class", "autocomplete-items");
    input.parentNode.appendChild(container);

    input.addEventListener("input", function() {
        let val = this.value;
        container.innerHTML = "";
        if (!val) {
            return false;
        }
        let filteredSuggestions = suggestions.filter(function(suggestion) {
            return suggestion.toLowerCase().startsWith(val.toLowerCase());
        });
        filteredSuggestions.forEach(function(filteredSuggestion) {
            let suggestionDiv = document.createElement("div");
            suggestionDiv.innerHTML = filteredSuggestion;
            suggestionDiv.addEventListener("click", function() {
                input.value = this.innerHTML;
                container.innerHTML = "";
            });
            container.appendChild(suggestionDiv);
        });
    });

    document.addEventListener("click", function(e) {
        container.innerHTML = "";
    });