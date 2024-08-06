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



//for editing profile

document.getElementById('editButton').addEventListener('click', function () {
  var editableElements = document.querySelectorAll('.editable');
  var editButton = document.getElementById('editButton');
  var doneButton = document.getElementById('doneButton');

  editableElements.forEach(function (element) {
    element.contentEditable = true;
    element.style.border = '1px solid #007bff';
    element.style.padding = '8px';
    element.style.margin = '10px';
  });
  editButton.style.display = 'none';
  doneButton.style.display = 'inline-block';
});

document.getElementById('doneButton').addEventListener('click', function () {
  var editableElements = document.querySelectorAll('.editable');
  var editButton = document.getElementById('editButton');
  var doneButton = document.getElementById('doneButton');

  editableElements.forEach(function (element) {
    element.contentEditable = false;
    element.style.border = '0px';
  });

  editButton.style.display = 'inline-block';
  doneButton.style.display = 'none';
});





