document.addEventListener("DOMContentLoaded", function () {
  fetch("get_restaurants.php")
    .then(response => response.json())
    .then(data => {
      const container = document.querySelector("#restaurant-section");

      if (!container) return;

      data.forEach(restaurant => {
        const card = document.createElement("div");
        card.className = "restaurant-card reveal";

        card.innerHTML = `
          <img src="${restaurant.image_url}" alt="${restaurant.name}">
          <h3>${restaurant.name}</h3>
          <p><strong>Location:</strong> ${restaurant.location}</p>
          <p><strong>Contact:</strong> ${restaurant.contact}</p>
          <p><strong>Cuisine:</strong> ${restaurant.cuisine}</p>
          <p><strong>Rating:</strong> ${restaurant.rating}</p>
          <p><strong>Price Range:</strong> ${restaurant.price_range}</p>
        `;

        container.appendChild(card);
      });

      // Re-run animation logic if needed
      const reveals = document.querySelectorAll(".reveal");
      function reveal() {
        for (let i = 0; i < reveals.length; i++) {
          let windowHeight = window.innerHeight;
          let elementTop = reveals[i].getBoundingClientRect().top;
          let elementVisible = 150;

          if (elementTop < windowHeight - elementVisible) {
            reveals[i].classList.add("active");
          }
        }
      }

      window.addEventListener("scroll", reveal);
      reveal();
    })
    .catch(error => console.error("Error fetching restaurants:", error));
});
