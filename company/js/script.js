document.addEventListener('DOMContentLoaded', function () {
  const sidebar = document.querySelector('.sidebar');
  const toggleButton = document.querySelector('.toggle');
  const contentSections = document.querySelectorAll('.content-section');
  const menuLinks = document.querySelectorAll('.menu-links a');

  toggleButton.addEventListener('click', function () {
    sidebar.classList.toggle('close');
  });

  menuLinks.forEach(function (link, index) {
    link.addEventListener('click', function (event) {
      event.preventDefault();
      const targetSectionId = contentSections[index].id;
      showSection(targetSectionId);
      highlightActiveLink(link);
    });
  });

  // Show the "Profile" section by default
  showSection('profile-section');
  highlightActiveLink(menuLinks[0]); // Highlight the first link initially

  function showSection(sectionId) {
    contentSections.forEach(function (section) {
      section.style.display = section.id === sectionId ? 'block' : 'none';
    });
  }

  function highlightActiveLink(activeLink) {
    menuLinks.forEach(function (link) {
      link.classList.remove('active');
    });
    activeLink.classList.add('active');
  }
});





const addBox = document.querySelector('.add-box');
const productFormContainer = document.getElementById('productFormContainer');
const closeForm = document.querySelector('.close-form');

addBox.addEventListener('click', () => {
  productFormContainer.style.display = 'block';
});

closeForm.addEventListener('click', () => {
  productFormContainer.style.display = 'none';
});












