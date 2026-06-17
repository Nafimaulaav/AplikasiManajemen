Cypress.on("uncaught:exception", (err) => {
  if (err.message.includes("Element attr did not return a valid number")) {
    return false;
  }

  return true;
});

describe("Testing Quality Control Admin", { testIsolation: false }, () => {
  const dataQC = {
    tanggal: "2026-06-16T08:00",
    namaPetugas: "Admin",
    varietas: "Melon Golden Admin",
    status: "Vegetatif",
    total: "100",
    tumbuh: "95",
    sehat: "90",
    sakit: "5",
    mati: "5",
    };

    const dataEditQC = {
    tanggal: "2026-06-16T08:30",
    namaPetugas: "Admin",
    varietas: "Melon Golden Admin Edit",
    status: "Generatif",
    total: "100",
    tumbuh: "96",
    sehat: "92",
    sakit: "4",
    mati: "4",
    };

    const dataTidakValid = {
    tanggal: "2026-06-16T09:00",
    namaPetugas: "Admin",
    varietas: "Melon Golden Admin Invalid",
    status: "Vegetatif",
    total: "100",
    tumbuh: "95",
    sehat: "90",
    sakit: "20",
    mati: "10",
    };

  before(() => {
    cy.login("admin", "admin123");
    cy.bukaDetailGreenhouse(0);
  });

  function uploadGambarQC(modalSelector) {
    const gambarQC = [
        "cypress/fixtures/qc1.jpg",
        "cypress/fixtures/qc2.jpg",
        "cypress/fixtures/qc3.jpg",
        "cypress/fixtures/qc4.jpg",
    ];

    cy.get(`${modalSelector} input[name="gambar_qc[]"]`, { timeout: 10000 })
        .should("exist")
        .selectFile(gambarQC, { force: true })
        .then(($input) => {
        expect($input[0].files.length).to.be.greaterThan(0);
        });
    }

  function isiFormQC(modalSelector, data, pakaiGambar = true) {
    cy.get(`${modalSelector} input[name="tanggal_qc"]`)
      .clear({ force: true })
      .type(data.tanggal, { force: true });

    cy.get(`${modalSelector} input[name="nama_petugas"]`)
      .clear({ force: true })
      .type(data.namaPetugas, { force: true });

    cy.get(`${modalSelector} input[name="varietas_melon"]`)
      .clear({ force: true })
      .type(data.varietas, { force: true });

    cy.get(`${modalSelector} select[name="status_tumbuh"]`)
      .select(data.status, { force: true });

    cy.get(`${modalSelector} input[name="total_tanaman"]`)
      .clear({ force: true })
      .type(data.total, { force: true });

    cy.get(`${modalSelector} input[name="jumlah_tanaman_tumbuh"]`)
      .clear({ force: true })
      .type(data.tumbuh, { force: true });

    cy.get(`${modalSelector} input[name="jumlah_tanaman_sehat"]`)
      .clear({ force: true })
      .type(data.sehat, { force: true });

    cy.get(`${modalSelector} input[name="jumlah_tanaman_sakit"]`)
      .clear({ force: true })
      .type(data.sakit, { force: true });

    cy.get(`${modalSelector} input[name="jumlah_tanaman_mati"]`)
      .clear({ force: true })
      .type(data.mati, { force: true });

    if (pakaiGambar) {
      uploadGambarQC(modalSelector);
    }
  }

  function bukaModalTambahQC() {
    cy.tutupSemuaModal();

    cy.get("#modalTambahQC", { timeout: 10000 })
      .should("exist")
      .then(($modal) => {
        $modal.css("display", "block");
        $modal.css("opacity", "1");
        $modal.css("visibility", "visible");
        $modal.addClass("show");
      });

    cy.get("#modalTambahQC")
      .should("be.visible");
  }

  function bukaModalEditQC(teksQC) {
    cy.tutupSemuaModal();

    cy.contains(".gh-qc-card", teksQC, { timeout: 10000 })
      .then(($card) => {
        cy.wrap($card)
          .find(".gh-btn-edit")
          .first()
          .scrollIntoView()
          .click({ force: true });

        cy.wrap($card)
          .find('[id^="modalEditQC"]')
          .first()
          .invoke("attr", "id")
          .then((idModal) => {
            cy.showGHModalIfHidden(`#${idModal}`);
            cy.wrap(`#${idModal}`).as("modalEditQC");
          });
      });
  }

  function bukaModalHapusQC(teksQC) {
    cy.tutupSemuaModal();

    cy.contains(".gh-qc-card", teksQC, { timeout: 10000 })
        .should("exist")
        .scrollIntoView()
        .within(() => {
        cy.get(".gh-btn-hapus")
            .first()
            .should("exist")
            .invoke("attr", "onclick")
            .then((onclickValue) => {
            expect(onclickValue, "onclick tombol hapus").to.exist;

            const hasil = onclickValue.match(/modalDeleteQC\d+/);
            expect(hasil, "ID modal hapus QC").to.not.be.null;

            const idModal = hasil[0];
            const modalSelector = `#${idModal}`;

            cy.get(modalSelector)
                .should("exist")
                .then(($modal) => {
                $modal.css("display", "block");
                $modal.css("opacity", "1");
                $modal.css("visibility", "visible");
                });

            cy.wrap(modalSelector).as("modalHapusQC");
            });
        });
    }

  function klikBatalHapusQC(modalSelector) {
    cy.get(modalSelector)
        .find(".gh-modal-close")
        .first()
        .should("exist")
        .click({ force: true });

    cy.get(modalSelector)
        .should("not.be.visible");
    }

  it("TC.QC.ADMIN.001.001 - Admin dapat membuka riwayat quality control", () => {
    cy.contains("Riwayat Kontrol Kualitas")
      .should("be.visible");
  });

  it("TC.QC.ADMIN.002.002 - Admin tidak dapat menambahkan QC dengan data tidak valid", () => {
    bukaModalTambahQC();

    isiFormQC("#modalTambahQC", dataTidakValid);

    cy.get('#modalTambahQC button[type="submit"]')
      .click({ force: true });

    cy.contains("Jumlah tanaman sehat, sakit, dan mati tidak boleh melebihi total tanaman", {
      timeout: 10000,
    }).should("be.visible");

    cy.hideGHModal("#modalTambahQC");
  });

  it("TC.QC.ADMIN.002.001 - Admin dapat menambahkan data QC valid", () => {
    bukaModalTambahQC();

    isiFormQC("#modalTambahQC", dataQC);

    cy.get('#modalTambahQC button[type="submit"]')
        .click({ force: true });

    cy.contains("Data QC berhasil ditambahkan", { timeout: 10000 })
        .should("be.visible");

    cy.tutupSuccessModalJikaAda();

    cy.reload();

    cy.contains(".gh-qc-card", dataQC.varietas, { timeout: 10000 })
        .within(() => {
        cy.contains(dataQC.varietas).should("be.visible");
        cy.contains(dataQC.namaPetugas).should("be.visible");

        cy.get(".gh-qc-thumb")
            .should("have.length.greaterThan", 0);
        });
    });

  it("TC.QC.ADMIN.003.001 - Admin dapat mengubah data QC valid", () => {
    bukaModalEditQC(dataQC.varietas);

    cy.get("@modalEditQC").then((modalSelector) => {
      isiFormQC(modalSelector, dataEditQC);

      cy.get(`${modalSelector} button[type="submit"]`)
        .click({ force: true });
    });

    cy.contains("Data QC berhasil diperbarui", { timeout: 10000 })
      .should("be.visible");

    cy.tutupSuccessModalJikaAda();

    cy.reload();

    cy.contains(".gh-qc-card", dataEditQC.varietas, { timeout: 10000 })
      .within(() => {
        cy.contains(dataEditQC.varietas).should("be.visible");
        cy.contains(dataEditQC.namaPetugas).should("be.visible");
      });
  });

  it("TC.QC.ADMIN.003.002 - Admin tidak dapat mengubah QC dengan field wajib kosong", () => {
    bukaModalEditQC(dataEditQC.varietas);

    cy.get("@modalEditQC").then((modalSelector) => {
      cy.get(`${modalSelector} input[name="varietas_melon"]`)
        .invoke("val", "")
        .trigger("input")
        .trigger("change")
        .should("have.value", "");

      cy.get(`${modalSelector} button[type="submit"]`)
        .click({ force: true });

      cy.get(`${modalSelector} input[name="varietas_melon"]`)
        .then(($input) => {
          expect($input[0].checkValidity()).to.eq(false);
        });

      cy.hideGHModal(modalSelector);
    });
  });

  it("TC.QC.ADMIN.004.002 - Admin membatalkan proses hapus data QC dengan tombol silang", () => {
    bukaModalHapusQC(dataEditQC.varietas);

    cy.get("@modalHapusQC").then((modalSelector) => {
        klikBatalHapusQC(modalSelector);
    });

    cy.contains(".gh-qc-card", dataEditQC.varietas, { timeout: 10000 })
        .should("exist");
    });

  it("TC.QC.ADMIN.004.001 - Admin dapat menghapus data QC", () => {
    bukaModalHapusQC(dataEditQC.varietas);

    cy.get("@modalHapusQC").then((modalSelector) => {
        cy.get(`${modalSelector} button[type="submit"]`)
        .click({ force: true });
    });

    cy.contains("Data QC berhasil dihapus", { timeout: 10000 })
        .should("be.visible");

    cy.tutupSuccessModalJikaAda();

    cy.reload();

    cy.contains(dataEditQC.varietas)
        .should("not.exist");
    });
});