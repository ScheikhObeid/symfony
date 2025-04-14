// assets/controllers/admin_dropdown_controller.js
import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['menu']

  toggle() {
    this.menuTarget.classList.toggle('hidden')
    console.log("Hello from Stimulus - Hidden!");
  }

  hide(event) {
    if (!this.element.contains(event.target)) {
      this.menuTarget.classList.add('hidden')
    }
  }

  connect() {
    document.addEventListener('click', this.hide.bind(this))
  }

  disconnect() {
    document.removeEventListener('click', this.hide.bind(this))
  }
}