/**
 * Dawsha Dashboard — script.js
 * UI-only JavaScript: sidebar toggle, page navigation, view switching (list/add/edit),
 * login flow, and active nav highlighting.
 * No external APIs, no AI, no dependencies.
 */
(function () {
  "use strict";

  /* --------------------------------------------------------------------------
     Login page
     -------------------------------------------------------------------------- */
  var loginForm = document.getElementById("login-form");
  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();
      var btn = document.getElementById("login-btn");
      if (btn) { btn.disabled = true; btn.textContent = "..."; }
      // Simulate a brief loading then redirect to dashboard
      setTimeout(function () {
        window.location.href = "index.html";
      }, 1200);
    });
  }

  /* --------------------------------------------------------------------------
     Sidebar collapse toggle
     -------------------------------------------------------------------------- */
  var sidebar  = document.getElementById("sidebar");
  var mainArea = document.getElementById("main-area");
  var toggleBtn = document.getElementById("sidebar-toggle");

  if (toggleBtn && sidebar && mainArea) {
    toggleBtn.addEventListener("click", function () {
      sidebar.classList.toggle("collapsed");
      mainArea.classList.toggle("collapsed");
    });
  }

  /* --------------------------------------------------------------------------
     Highlight active nav item by current page filename
     -------------------------------------------------------------------------- */
  var currentFile = window.location.pathname.split("/").pop() || "index.html";
  var navItems = document.querySelectorAll(".nav-item[data-page]");
  navItems.forEach(function (item) {
    if (item.getAttribute("data-page") === currentFile) {
      item.classList.add("active");
    }
  });

  /* --------------------------------------------------------------------------
     Update toolbar title to match active nav item
     -------------------------------------------------------------------------- */
  var toolbarTitle = document.getElementById("toolbar-title");
  if (toolbarTitle) {
    navItems.forEach(function (item) {
      if (item.classList.contains("active")) {
        toolbarTitle.textContent = item.querySelector(".nav-label")
          ? item.querySelector(".nav-label").textContent
          : "";
      }
    });
  }

  /* --------------------------------------------------------------------------
     View switching — list / add / edit
     Each page may have buttons with data-switch="viewId" attribute.
     -------------------------------------------------------------------------- */
  function switchView(viewId) {
    var views = document.querySelectorAll(".view");
    views.forEach(function (v) { v.classList.remove("active"); });
    var target = document.getElementById(viewId);
    if (target) { target.classList.add("active"); }
    window.scrollTo(0, 0);
  }

  // Activate first view on load
  var views = document.querySelectorAll(".view");
  if (views.length > 0) { views[0].classList.add("active"); }

  // Wire up all switch buttons
  document.querySelectorAll("[data-switch]").forEach(function (btn) {
    btn.addEventListener("click", function () {
      switchView(this.getAttribute("data-switch"));
    });
  });

  /* Filter tabs (users page) — visual toggle only */
  document.querySelectorAll(".filter-tabs").forEach(function (wrap) {
    wrap.querySelectorAll("button").forEach(function (b) {
      b.addEventListener("click", function () {
        wrap.querySelectorAll("button").forEach(function (x) {
          x.classList.remove("is-on");
        });
        b.classList.add("is-on");
      });
    });
  });

  /* --------------------------------------------------------------------------
     Optional: current year in footer
     -------------------------------------------------------------------------- */
  var yearEl = document.querySelector("[data-year]");
  if (yearEl) { yearEl.textContent = String(new Date().getFullYear()); }

  /* --------------------------------------------------------------------------
     Logout button — back to login
     -------------------------------------------------------------------------- */
  var logoutBtn = document.getElementById("logout-btn");
  if (logoutBtn) {
    logoutBtn.addEventListener("click", function () {
      window.location.href = "login.html";
    });
  }

})();
