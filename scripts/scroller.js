let handle = (scroll, scroller = scroll.closest(".scroller")) => {
	let scrollerBorder
	let scrollerHeight
	let scrollMargin
	if (document.body === scroller) {
		scrollerHeight = window.innerHeight
		scrollerBorder = 0
		scrollMargin = 0
	}
	else {
		scrollerHeight = scroller.clientHeight
		scrollerBorder = +getComputedStyle(scroller).borderTopWidth.slice(0, -2)
		scrollMargin = +getComputedStyle(scroll).marginTop.slice(0, -2)
	}
	scroll.style.top = Math.min(0, scrollerHeight - scroll.offsetHeight) + scrollerBorder - scrollMargin + "px"
}

let scrollObserver = new ResizeObserver(changes => changes.forEach(({target}) => handle(target)))

for (let scroll of document.querySelectorAll(".scroller > *")) {
	handle(scroll)
	scrollObserver.observe(scroll)
}

let scrollerObserver = new ResizeObserver(changes => changes.forEach(({target}) => [...target.children].forEach(scroll => handle(scroll, target))))

for (let scroller of document.querySelectorAll(".scroller")) {
	scrollerObserver.observe(scroller)
}
