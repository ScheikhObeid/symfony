import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ['slides']
    currentIndex = 0
    interval = null

    connect() {
        this.slideCount = this.slidesTarget.children.length
        this.startLoop()
        this.slidesTarget.addEventListener('transitionend', this.checkReset.bind(this))
    }

    disconnect() {
        clearInterval(this.interval)
    }

    startLoop() {
        this.interval = setInterval(() => {
            this.next()
        }, 4000)
    }

    next() {
        this.currentIndex++
        this.updateSlide(true)
    }

    updateSlide(withTransition = true) {
        const offset = this.currentIndex * this.slidesTarget.clientWidth
        this.slidesTarget.style.transition = withTransition ? 'transform 0.7s ease-in-out' : 'none'
        this.slidesTarget.style.transform = `translateX(-${offset}px)`
    }

    checkReset() {
        // If we're at the cloned slide, reset back to real first slide
        if (this.currentIndex === this.slideCount - 1) {
            this.updateSlide(false) // instantly reset
            this.currentIndex = 0
            requestAnimationFrame(() => this.updateSlide(false))
        }
    }
}
