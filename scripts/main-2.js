let main = document.querySelector("#main")

let goto = async (href, options = {}, history = true) => {
	// let pagename = pagenames[href.split("/")[0]]
	let response = await fetch(new URL("public/" + href, document.baseURI), options)
	if (response.ok) {
		let text = await response.text()
		scrollTo(0, 0)

		main.innerHTML = text

		/*
		if(href === "home.php")
		{
			big.removeAttribute("href")
			mini.removeAttribute("href")
		}
		else
		{
			big.href = mini.href = "home.php"
		}
		
		for(let a of navlinks)
		{
			let dhref = a.dataset.href
			if(href === dhref)
			{
				a.removeAttribute("href")
			}
			else
			{
				a.href = dhref
			}
		}
		*/

		if (history) {
			window.history.pushState(null, null, "main.php/" + href)
		}
	}
	else {
		goto("mistake.php", {}, false)
	}
}

window.addEventListener("click", event => {
	let target = event.target

	let out = false
	for (let current = target; current; current = current.parentNode) {
		let href
		if (current.localName === "a" && (href = current.getAttribute("href")) && /^main\.php(\/.*)?$/.test(href)) {
			goto(href.slice("main.php/".length))
			event.preventDefault()
			out = true
			break
		}
	}
}, {capture: true})