/**--------------------------------------------------------------------------------------------------------------
	* Nome: Copia.js
	* Autor: LM
	* Objetivo: Script responsável pela operação de cópia de frase no front-end
	* Doc: https://docs.google.com/document/d/1o0HTZWCPbzgD56ET5GC96VN0F_iePfdWePxf4Fha6G4/edit#
	* -------------------------------------------------------
	* UPDATES:
	* -------------------------------------------------------
	*  ● Projeto2023Jan06 - ● Dois é dimais: tirar duplicidade do código na ação copiar frase
	*     >> 13-01-23 - Remover o span de copiar frase - adaptar o script para pegar a div $frase_id.
	*--------------------------------------------------------------------------------------------------------------*/

import { Messenger } from "./Messenger"
const Copia = {
	preLoad() {
		let copiarFraseFavorita = document.querySelectorAll(".copiarFraseFavorita")
		// let dados
		copiarFraseFavorita.forEach(item => {
			item.onclick = function (e) {
				e.stopPropagation()
				e.preventDefault()
				let id = e.target.attributes.idData.nodeValue
				Copia.copiarFraseFavorita(id)
			}
		})
	},
	copiarFraseFavorita(frase) {
		//colocar na área de transfrência todo o conteúdo copiado
		let tempInput = document.createElement("input")
		let CopiarFrase = document.querySelector("#frase_" + frase).innerHTML

		document.body.appendChild(tempInput)

		tempInput.value = CopiarFrase
		tempInput.select()
		try {
			// var successful = 
			document.execCommand("copy")
			Messenger.view("Frase copiada!", "sucesso")
			//alert('A Frase foi copiada com sucesso! ');
			document.body.removeChild(tempInput)
		} catch (err) {
			//alert('Oops, não foi possível copiar.');
			Messenger.view("Oops, não foi possível copiar.", "sucesso")
		}
	},
}
export { Copia }