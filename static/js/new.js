let next_id = 1;

document.addEventListener("DOMContentLoaded", () => {
	let choices = document.getElementById("choices");
	let choice_template = document.getElementById("choice");

	function create_choice()
	{
		let choice = document.createElement("div");
		choice.classList.add("choice");
		choice.innerHTML = choice_template.innerHTML.replace(/:id/g, next_id);
		choice.querySelector("button.delete").addEventListener("click", () => {
			choices.removeChild(choice);
		});
		choices.append(choice);
		next_id++;
	}

	document.getElementById("add-choice").addEventListener("click", create_choice);
	while(next_id < 4) create_choice();

	let form = document.getElementById("newpoll");
	form.addEventListener("submit", (event) => {
		event.preventDefault();

		function get_choices(form)
		{
			let choices = [];
			form.querySelectorAll("#choices .choice input").forEach((el) => {
				choices.push(el.value);
			});
			return choices;
		}

		fetch("/polls", {
			method: "POST",
			body: JSON.stringify({
				title: form.querySelector(`input[name="title"]`).value,
				options: get_choices(form),
                settings: {
                    "unique_ip": form.querySelector(`input[name="unique_ip"]`).checked,
                }
			}),
			headers: {
				"Content-Type": "application/json",
			},
		}).then((res) => {
			return res.json();
		}).then((json) => {
			form.setAttribute("hidden", true);
			let result_el = document.getElementById("result");
			result_el.innerHTML = result_el.innerHTML.replace(/:poll_title/g, json.title);
			result_el.innerHTML = result_el.innerHTML.replace(/:poll_url/g, `/polls/${json.id}`);
			result_el.innerHTML = result_el.innerHTML.replace(/:delete_url/g, `/polls/${json.id}/${json.delete_token}`);
			result_el.removeAttribute("hidden");
		});
	});
});