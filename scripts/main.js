let pagenames = {}

for(let pagename of document.querySelector("#pagenames").textContent.split(";;"))
{
	let [code, name] = pagename.split('::')
	pagenames[code] = {name}
}

let main = document.querySelector("#main")

let navlinks = document.querySelectorAll("a[data-href]")

let carousel = document.querySelector("#carousel-hide")

let goto = async (href, options = {}, history = true) =>
{
	let code = href.split("?")[0]
	let pagename = pagenames[code.split("/")[0]||"index.php"]||{}
	let response = await fetch(new URL("public/"+href, document.baseURI), options)
	
	let nhref = "main.php/" + href

	if(history)
	{
		window.history.pushState(null, null, nhref)
		for(let a of navlinks)
		{
			let dhref = a.dataset.href
			if(nhref === dhref)
			{
				a.removeAttribute("href")
			}
			else
			{
				a.href = dhref
			}
		}
	}
	
	if(response.ok)
	{
		let text = await response.text()
		scrollTo(0, 0)
		
		document.title = "Houzion \u2014 " + pagename.name
		
		main.innerHTML = text
	}
	else
	{
		goto("mistake.php", {}, false)
	}
}

window.addEventListener("click", event =>
{
	let target = event.target
	
	for(let current = target; current; current = current.parentNode)
	{
		if(current.localName === "a")
		{
			let href = current.getAttribute("href")
			if(href && /^main\.php\/?/u.test(href))
			{
				goto(href.slice("main.php/".length))
				event.preventDefault()
				break
			}
		}
		else if((current.localName === "button" || current.localName === "input") && current.type === "submit")
		{
			let form = current.form
			let action = form.getAttribute("action")||""
			if(!action || /^main\.php\/?/u.test(action))
			{
				let method = form.method
				if(method === "get")
				{
					goto(new URL(new URLSearchParams(new FormData(form)), action), {method})
				}
				else
				{
					goto(action, {method, body: new FormData(form)})
				}
				event.preventDefault()
				break
			}
		}
	}
}, {capture: true})



