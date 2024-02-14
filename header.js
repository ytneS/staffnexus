document.addEventListener("DOMContentLoaded", function () {
    const body = document.querySelector("body"),
      sidebar = document.querySelector(".sidebar"),
      toggle = body.querySelector(".toggle"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");
  
    // Check if mode is stored in localStorage
    const savedMode = localStorage.getItem("mode");
    if (savedMode) {
      body.classList.add(savedMode);
      if (savedMode === "dark") {
        modeText.innerText = "Light Mode";
      } else {
        modeText.innerText = "Dark Mode";
      }
    }
  
    toggle.addEventListener("click", () => {
      sidebar.classList.toggle("close");
    });
  
      modeSwitch.addEventListener("click", () => {
        body.classList.toggle("dark");
  
      // Update modeText based on the current mode
      if (body.classList.contains("dark")) {
            modeText.innerText = "Light Mode";
            // Save the mode in localStorage
            localStorage.setItem("mode", "dark");
      } else {
            modeText.innerText = "Dark Mode";
            // Save the mode in localStorage
            localStorage.setItem("mode", "light");
      }
    });
  });
  