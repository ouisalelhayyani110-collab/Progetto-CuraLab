describe("Navigazione CuraLab", () => {
  it("dalla home raggiunge la pagina Chi siamo", () => {
    cy.visit("/");

    // Il link "Chi siamo" è nell'header
    cy.get('a[href*="/chi-siamo"]').first().click();

    cy.url().should("include", "/chi-siamo");
    cy.contains("Chi siamo");
  });

  it("mostra l'header del brand", () => {
    cy.visit("/");
    cy.contains("CuraLab");
    cy.get('a[href="/medici"]').should("exist");
  });
});
