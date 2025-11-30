import languageCodes from "./utils/languageCodes"
import httpRequest from "./utils/http-request"
import "regenerator-runtime/runtime";

const { languageInEnglish, alpha2Codes } = languageCodes;

const capitalize = (language: string) => {
  return language.charAt(0).toUpperCase() + language.toLowerCase().slice(1)
}

const getAlpha2Code = (language: string) => {
  const codeIndex = languageInEnglish.indexOf(language);
  // ✅ fix: handle index properly, even if 0
  const alpha2Code = codeIndex >= 0 ? alpha2Codes[codeIndex] : null;
  return alpha2Code;
}

const countryExtractor = (countriesObject: { [x: string]: { name: any; }; }) => {
  const countriesArray = []
  for (const country in countriesObject) {
    countriesArray.push(countriesObject[country].name)
  }
  return countriesArray
}

const countryListLookup = async (alpha2Code: string | number, callback?: Function) => {
  try {
    const res = await httpRequest(alpha2Code)
    const countries = res?.data ? countryExtractor(res.data) : []
    if (callback) callback(countries)   // ✅ tawagin ang callback
    return countries
  } catch (error) {  
    if (callback) callback([])          // ✅ safe fallback
    return []  
  } 
}


const getResponse = (language: string, listOfPlaces?: string[] ) => {
  const safeList = listOfPlaces ?? []   // ✅ default to empty array
  return `${capitalize(language)} is spoken in ${safeList.length} countries around the world`
}

export {
  capitalize,
  getAlpha2Code,
  countryExtractor,
  countryListLookup,
  getResponse
};
