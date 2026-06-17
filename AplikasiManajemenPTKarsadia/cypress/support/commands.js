Cypress.Commands.add("login", (username, password) => {
  cy.clearCookies();
  cy.clearLocalStorage();

  cy.visit("/login");

  cy.get('input[name="username"], input[name="email"], input[type="text"]')
    .first()
    .clear({ force: true })
    .type(username, { force: true });

  cy.get('input[name="password"], input[type="password"]')
    .first()
    .clear({ force: true })
    .type(password, { force: true });

  cy.get('button[type="submit"], input[type="submit"], .btn-login')
    .first()
    .click({ force: true });

  cy.url({ timeout: 10000 }).should("not.include", "/login");
});

Cypress.Commands.add("bukaDetailGreenhouse", (index = 0) => {
  cy.visit("/greenhouse");

  cy.get('a[href*="/greenhouse/"]', { timeout: 10000 })
    .eq(index)
    .click({ force: true });

  cy.contains("Riwayat Kontrol Kualitas", { timeout: 10000 })
    .should("be.visible");
});

Cypress.Commands.add("tutupSemuaModal", () => {
  cy.get("body").then(($body) => {
    const $modal = $body.find(".gh-modal, .modal");

    if ($modal.length > 0) {
      cy.wrap($modal).each(($el) => {
        cy.wrap($el).invoke("hide");
      });
    }
  });
});

Cypress.Commands.add("showModalIfHidden", (modalSelector) => {
  cy.get(modalSelector, { timeout: 10000 })
    .should("exist")
    .then(($modal) => {
      $modal.css("display", "block");
      $modal.css("opacity", "1");
      $modal.css("visibility", "visible");
      $modal.addClass("show");
    });

  cy.get(modalSelector).should("be.visible");
});

Cypress.Commands.add("showGHModalIfHidden", (modalSelector) => {
  cy.showModalIfHidden(modalSelector);
});

Cypress.Commands.add("hideGHModal", (modalSelector) => {
  cy.get(modalSelector)
    .then(($modal) => {
      $modal.css("display", "none");
      $modal.css("opacity", "0");
      $modal.css("visibility", "hidden");
      $modal.removeClass("show");
    });
});

Cypress.Commands.add("tutupSuccessModalJikaAda", () => {
  cy.get("body").then(($body) => {
    const tombolTutup = $body.find(
      '.swal2-confirm, .btn-close, button:contains("OK"), button:contains("Tutup")'
    );

    if (tombolTutup.length > 0) {
      cy.wrap(tombolTutup.first()).click({ force: true });
    }
  });
});