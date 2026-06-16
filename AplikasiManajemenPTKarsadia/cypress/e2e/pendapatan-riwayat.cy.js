describe('Pengujian Fitur Pendapatan dan Riwayat', () => {

  it('Membuka halaman Pendapatan', () => {
    cy.visit('http://127.0.0.1:8000/pendapatan')

    cy.contains('Laporan Pendapatan').should('be.visible')
    cy.contains('Rekap Transaksi').should('be.visible')
  })

  it('Menampilkan popup Tambah Transaksi', () => {
    cy.visit('http://127.0.0.1:8000/pendapatan')

    cy.contains('Tambah Transaksi').click()

    cy.contains('Tambah Transaksi Baru').should('be.visible')
    cy.get('input').should('have.length.at.least', 4)
  })

  it('Membuka halaman Riwayat', () => {
    cy.visit('http://127.0.0.1:8000/riwayat')

    cy.contains('Riwayat Aktivitas').should('be.visible')
  })

  it('Menampilkan tabel Riwayat', () => {
    cy.visit('http://127.0.0.1:8000/riwayat')

    cy.contains('Waktu').should('be.visible')
    cy.contains('Petugas').should('be.visible')
    cy.contains('Aksi').should('be.visible')
    cy.contains('Menu').should('be.visible')
    cy.contains('Deskripsi').should('be.visible')
  })

})