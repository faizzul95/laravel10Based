// DEBUG HELPER

/**
 * Function: log
 * Description: This function takes in multiple arguments and logs each argument to the console.
 * It iterates through the provided arguments and uses the console.log() function to display each argument's value in the console.
 *
 * @param {...any} args - The arguments to be logged to the console.
 * 
 * @example
 * log("Hello", 42, [1, 2, 3]);
 */
const log = (...args) => {
	args.forEach((param) => {
		console.log(param);
	});
}

/**
 * Function: dd
 * Description: This function is similar to the 'log' function, but it additionally throws an error after logging the provided arguments.
 * It is typically used for debugging purposes to terminate program execution and print diagnostic information at a specific point in the code.
 *
 * @param {...any} args - The arguments to be logged to the console before terminating the execution.
 * @throws {Error} - Always throws an error with the message "Execution terminated by dd()".
 * 
 * @example
 * dd("Error occurred", { code: 500 });
 */
const dd = (...args) => {
	args.forEach((param) => {
		console.log(param);
	});
	throw new Error("Execution terminated by dd()");
}

// DATA HELPER

/**
 * Function: isset
 * Description: Checks if a variable is defined and not null.
 *
 * @param {*} variable - The variable to be checked.
 * @returns {boolean} - True if the variable is defined and not null, false otherwise.
 * 
 * @example
 * const result = isset(myVar);
 * if (result) {
 *   // myVar is defined and not null
 * } else {
 *   // myVar is undefined or null
 * }
 */
const isset = (variable) => {
	return typeof variable != 'undefined' && variable != null;
};

/**
 * Function: trimData
 * Description: Trims leading and trailing whitespace from a given string if it's defined, otherwise returns original text.
 *
 * @param {*} text - The text to be potentially trimmed.
 * @returns {string | *} - Returns the trimmed string or the original value if input is not a string.
 * 
 * @example
 * const trimmedText = trimData("   Some text   "); // trimmedText now contains "Some text"
 * const nullResult = trimData(null); // nullResult is null
 * const numberResult = trimData(6); // numberResult return as is
 */
const trimData = (text) => {
	return typeof text === 'string' ? text.trim() : text;
};

/**
 * Function: hasData
 * Description: Check if data exists and optionally if a nested key exists within the data.
 *
 * @param {any} data - The data to be checked.
 * @param {string} arrKey - A dot-separated string representing the nested keys to check within the data.
 * @param {boolean} returnData - If true, return the data instead of a boolean.
 * @param {any} defaultValue - The value to return if the data or nested key is not found.
 * @returns {boolean | any} - Returns a boolean indicating data existence or the actual data based on `returnData` parameter.
 */
const hasData = (data = null, arrKey = null, returnData = false, defaultValue = null) => {
	if (!data || data === '' || data === 'null') {
		return returnData ? defaultValue : false;
	}

	if (!arrKey) {
		return true;
	}

	const keys = arrKey.split('.');
	let currentData = data;

	for (const key of keys) {
		if (!(key in currentData)) {
			return returnData ? defaultValue : false;
		}
		currentData = currentData[key];
	}

	return !returnData ? true : (!currentData || currentData === 'null' ? defaultValue : currentData);
};

/**
 * Function: replaceTextWithData
 * Replaces placeholders in a string with corresponding data values.
 * Placeholders are defined as %placeholder_name%.
 * If a data value for a placeholder is not found, the placeholder remains unchanged.
 *
 * @param {string} string - The input string containing placeholders.
 * @param {object} data - An object containing key-value pairs for replacement.
 * @returns {string} - The string with placeholders replaced by data values.
 */
const replaceTextWithData = (string = '', data) => {
	// Use regular expression to match %placeholder%
	return string.replace(/%([^%]+)%/g, (match, key) => {
		// If a data value exists for the key, replace with the value; otherwise, keep the original placeholder
		return data[key] || match;
	});
};

/**
 * Function: ucfirst
 * Description: Converts the first character of a string to uppercase.
 *
 * @param {string} string - The input string.
 * @returns {string} - The input string with the first character capitalized.
 * 
 * @example
 * const result = ucfirst("hello"); // Result is "Hello"
 */
const ucfirst = (string) => {
	try {
		if (typeof string !== 'string') {
			throw new Error(`An error occurred in ucfirst(): Input must be a string`);
		}
		return string.charAt(0).toUpperCase() + string.slice(1);
	} catch (error) {
		console.error(`An error occurred in ucfirst(): ${error.message}`);
		return string;
	}
}

/**
 * Function: ucwords
 * Description: Capitalizes the first character of each word in a string.
 *
 * @param {string} str - The input string.
 * @returns {string} - The input string with the first character of each word capitalized.
 * 
 * @example
 * const result = ucwords("hello world"); // Result is "Hello World"
 */
const ucwords = (str) => {
	try {
		if (typeof str !== 'string') {
			throw new Error(`An error occurred in ucwords(): Input must be a string`);
		}
		return str.toLowerCase().split(' ').map(function (word) {
			return word.replace(word[0], word[0].toUpperCase());
		}).join(' ');
	} catch (error) {
		console.error(`An error occurred in ucwords(): ${error.message}`);
		return str;
	}
}

/**
 * Function: strtoupper
 * Description: Converts the value of string to uppercase
 *
 * @param {string} str - The input string.
 * @returns {string} - The input string with the uppercase.
 * 
 * @example
 * const result = strtoupper('hello'); // Result is "HELLO"
 */
const strtoupper = (str) => {
	try {
		if (typeof str !== 'string') {
			throw new Error(`An error occurred in strtoupper(): Input must be a string`);
		}
		return str.toUpperCase();
	} catch (error) {
		console.error(`An error occurred in strtoupper(): ${error.message}`);
		return str;
	}
}

/**
 * Function: strtolower
 * Description: Converts a string to lowercase.
 *
 * @param {string} str - The input string.
 * @return {string} - The input string converted to lowercase.
 *
 * @example
 * const result = strtolower("Hello World"); // result is "hello world"
 */
const strtolower = (str) => {
	try {
		if (typeof str !== 'string') {
			throw new Error(`An error occurred in strtolower(): Input must be a string`);
		}
		return str.toLowerCase();
	} catch (error) {
		console.error(`An error occurred in strtolower(): ${error.message}`);
		return str;
	}
}

/**
 * Function: str_replace
 * Description: Replaces all occurrences of a substring in a string with another substring.
 *
 * @param {string} find - The substring to be replaced.
 * @param {string} replace - The replacement substring.
 * @param {string} string - The input string.
 * @return {string} - The input string with all occurrences of the search substring replaced by the replace substring.
 *
 * @example
 * const result = str_replace("world", "universe", "Hello world"); // result is "Hello universe"
 */
const str_replace = (find, replace, string) => {

	try {
		if (typeof string !== 'string') {
			throw new Error(`An error occurred in str_replace(): String text must be a string`);
		}

		if (typeof find !== 'string') {
			throw new Error(`An error occurred in str_replace(): Find must be a string`);
		}

		if (typeof replace !== 'string') {
			throw new Error(`An error occurred in str_replace(): Replace must be a string`);
		}

		return string.split(find).join(replace);
	} catch (error) {
		console.error(`An error occurred in str_replace(): ${error.message}`);
		return str;
	}
}

// ARRAY HELPER

/**
 * Function: in_array
 * Description: Checks if a given value exists in the provided array.
 *
 * @param {*} needle - The value to search for in the array.
 * @param {Array} data - The array to search within.
 * @returns {boolean} - True if the value exists in the array, false otherwise.
 * 
 * @example
 * const result = in_array(42, [1, 42, 3]); // result is true
 */
const in_array = (needle, data) => {
	if (!Array.isArray(data)) {
		throw new Error("An error occurred in in_array(): data should be an array");
	}

	try {
		return data.includes(needle);
	} catch (error) {
		throw new Error(`An error occurred in in_array(): ${error.message}`);
	}
}

/**
 * Function: array_push
 * Description: Adds one or more elements to the end of an array and returns the new length of the array.
 *
 * @param {Array} data - The array to which elements will be added.
 * @param {...*} elements - Elements to be added to the array.
 * @returns {number} - The new length of the array.
 * 
 * @example
 * const myArray = [1, 2];
 * const newLength = array_push(myArray, 3, 4); // myArray is now [1, 2, 3, 4], newLength is 4
 */
const array_push = (data, ...elements) => {
	if (!Array.isArray(data)) {
		throw new Error("An error occurred in array_push(): data should be an array");
	}

	try {
		return data.push(...elements);
	} catch (error) {
		throw new Error(`An error occurred in array_push(): ${error.message}`);
	}
}

/**
 * Function: array_merge
 * Description: Merges multiple arrays into a single array.
 *
 * @param {...Array} arrays - Arrays to be merged.
 * @returns {Array} - The merged array.
 * 
 * @example
 * const mergedArray = array_merge([1, 2], [3, 4], [5, 6]); // mergedArray is [1, 2, 3, 4, 5, 6]
 */
const array_merge = (...arrays) => {
	for (const array of arrays) {
		if (!Array.isArray(array)) {
			throw new Error("All arguments should be arrays");
		}
	}

	try {
		return [].concat(...arrays);
	} catch (error) {
		throw new Error(`An error occurred in array_merge(): ${error.message}`);
	}
}

/**
 * Function: implode
 * Description: Joins elements of an array into a string using a specified separator.
 *
 * @param {string} separator - The separator string used between array elements.
 * @param {Array} data - The array whose elements will be joined.
 * @returns {string} - The joined string.
 * 
 * @example
 * const result = implode(', ', ['apple', 'banana', 'orange']); // result is "apple, banana, orange"
 */
const implode = (separator = ',', data) => {
	if (data !== null && !Array.isArray(data)) {
		throw new Error(`An error occurred in implode(): data should be an array`);
	}

	try {
		return data.join(separator);
	} catch (error) {
		throw new Error(`An error occurred in implode(): ${error.message}`);
	}
}

/**
 * Function: explode
 * Description: Splits a string into an array of substrings based on a specified delimiter.
 *
 * @param {string} delimiter - The delimiter to use for splitting the string.
 * @param {string} data - The string to be split.
 * @returns {Array} - An array of substrings.
 * 
 * @example
 * const result = explode(' ', 'Hello world'); // result is ["Hello", "world"]
 */
const explode = (delimiter = ',', data) => {
	if (typeof data !== 'string') {
		throw new Error("An error occurred in explode(): data should be a string");
	}

	try {
		return data.split(delimiter);
	} catch (error) {
		throw new Error(`An error occurred in explode(): ${error.message}`);
	}
}

/**
 * Function: array_key_exists
 * Description: Checks if a specified key exists in an object.
 *
 * @param {*} arrKey - The key to check for existence in the object.
 * @param {Object} data - The object to check for the key's existence.
 * @returns {boolean} - True if the key exists in the object, false otherwise.
 * @throws {Error} - Throws an error if data is not an object.
 * 
 * @example
 * const obj = { name: 'John', age: 30 };
 * const result = array_key_exists('name', obj);
 * // result is true
 */
const array_key_exists = (arrKey, data) => {
	if (typeof data !== 'object' || data === null) {
		throw new Error("An error occurred in array_key_exists(): data should be an object");
	}

	try {
		if (data.hasOwnProperty(arrKey)) {
			return true;
		}

		return false;
	} catch (error) {
		throw new Error(`An error occurred in array_key_exists(): ${error.message}`);
	}
}

/**
 * Function: remove_item_array
 * Description: Removes a specified item from an array if it exists.
 *
 * @param {Array} data - The array from which the item will be removed.
 * @param {*} item - The item to be removed from the array.
 * @returns {*} - The removed item, or undefined if the item doesn't exist in the array.
 * 
 * @example
 * const myArray = [1, 2, 3, 4];
 * const removedItem = remove(myArray, 2); // myArray is now [1, 3, 4], removedItem is 2
 */
const remove_item_array = (data, item) => {
	if (!Array.isArray(data)) {
		throw new Error("An error occurred in remove_item_array(): data should be an array");
	}

	const index = data.indexOf(item);
	if (index > -1) {
		try {
			return data.splice(index, 1)[0];
		} catch (error) {
			throw new Error(`An error occurred in remove_item_array(): ${error.message}`);
		}
	}

	return undefined;
};

// DATE & TIME HELPER

/**
 * Function: getCurrentTime
 * Description: Gets the current time in the specified format.
 *
 * @param {boolean} use12HourFormat - Optional. If true, the time will be in 12-hour format (AM/PM).
 *                                    If false or not provided, the time will be in 24-hour format.
 * @param {boolean} hideSeconds - Optional. If true, the seconds portion will be hidden.
 * @returns {string} The current time in the specified format.
 *
 * @example
 * const result24 = getCurrentTime();                    // result is like "14:30:45"
 * const result12 = getCurrentTime(true);                // result is like "02:30:45 PM"
 * const result12NoSeconds = getCurrentTime(true, true); // result is like "02:30 PM"
 */
const getCurrentTime = (use12HourFormat = false, hideSeconds = false) => {
	try {
		const today = new Date();
		let hh = today.getHours();
		const mm = today.getMinutes().toString().padStart(2, '0');
		let ss = '';

		if (!hideSeconds) {
			ss = `:${today.getSeconds().toString().padStart(2, '0')}`;
		}

		let timeFormat = "24-hour";

		if (use12HourFormat) {
			timeFormat = "12-hour";
			const period = hh >= 12 ? "PM" : "AM";
			hh = hh % 12 || 12; // Convert 0 to 12 for 12-hour format
			return `${hh}:${mm}${ss} ${period}`;
		}

		hh = hh.toString().padStart(2, '0');
		return `${hh}:${mm}${ss}`;
	} catch (error) {
		console.error(`An error occurred in getCurrentTime(): ${error.message}`);
		return "00:00:00";
	}
};

/**
 * Function: getCurrentDate
 * Description: Gets the current date in YYYY-MM-DD format or a specified format.
 *
 * @param {string} format - The format date to return. Default is null.
 * @param {string} lang - The language code, either 'en' (English), 'my' (Malay), or 'id' (Indonesian). Default is 'en'.
 * @returns {string} - The current date.
 * 
 * @example
 * const result = getCurrentDate(); // result is like "2023-08-17"
 */
const getCurrentDate = (format = null, lang = 'en') => {
	try {
		const today = new Date();
		const dd = today.getDate().toString().padStart(2, '0');
		const mm = (today.getMonth() + 1).toString().padStart(2, '0'); // January is 0 so need to add 1
		const yyyy = today.getFullYear();
		return hasData(format) ? formatDate(`${yyyy}-${mm}-${dd}`, format, "1970-01-01", lang) : `${yyyy}-${mm}-${dd}`;
	} catch (error) {
		console.error(`An error occurred in getCurrentDate(): ${error.message}`);
		return "1970-01-01";
	}
}

/**
 * Function: getCurrentTimestamp
 * Description: Gets the current timestamp in the format "YYYY-MM-DD HH:MM:SS".
 *
 * @returns {string} The current timestamp in the format "YYYY-MM-DD HH:MM:SS".
 *
 * @example
 * const timestamp = getCurrentTimestamp(); // Returns something like "2023-08-17 14:30:45"
 */
const getCurrentTimestamp = () => {
	try {
		const now = new Date();
		const yyyy = now.getFullYear();
		const mm = (now.getMonth() + 1).toString().padStart(2, '0'); // January is 0 so need to add 1
		const dd = now.getDate().toString().padStart(2, '0');
		const hh = now.getHours().toString().padStart(2, '0');
		const min = now.getMinutes().toString().padStart(2, '0');
		const ss = now.getSeconds().toString().padStart(2, '0');

		return `${yyyy}-${mm}-${dd} ${hh}:${min}:${ss}`;
	} catch (error) {
		console.error(`An error occurred in getCurrentTimestamp(): ${error.message}`);
		return "1970-01-01 00:00:00"; // Return default value in case of error
	}
};

/**
 * Function: getClock
 * Description: Returns a formatted current time along with the day name and date in the specified language.
 *
 * @param {string} format - The time format, either '12' (12-hour) or '24' (24-hour). Default is '24'.
 * @param {string} lang - The language code, either 'en' (English), 'my' (Malay), or 'id' (Indonesian). Default is 'en'.
 * @param {boolean} showSeconds - Whether to include seconds in the formatted time string. Default is true.
 * 
 * @return {string} - The formatted time string.
 * 
 * @example
 * // const time = getClock('24', 'en', true); // Returns a 24-hour time string with seconds in English.
 */
const getClock = (format = '24', lang = 'en', showSeconds = true) => {
	try {
		// Define day names in English, Malay, and Indonesian
		const dayNames = {
			en: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
			my: ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'],
			id: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
		};

		// Validate the format parameter
		if (format !== '12' && format !== '24') {
			throw new Error("An error occurred in getClock(): Invalid format parameter. Use '12' or '24'.");
		}

		// Validate the lang parameter
		if (!dayNames[lang]) {
			throw new Error("An error occurred in getClock(): Invalid lang parameter. Use 'en', 'my', or 'id'.");
		}

		// Get the current date and time
		const currentTime = new Date();
		const currentDayIndex = currentTime.getDay(); // Get the day index (0-6)

		// Get the appropriate day name based on the current day index and language
		const dayName = dayNames[lang][currentDayIndex];

		// Get hours, minutes, and seconds
		let hours = currentTime.getHours();
		const minutes = currentTime.getMinutes();
		const seconds = currentTime.getSeconds();

		// Convert to 12-hour format and determine AM/PM if format is '12'
		let ampm = '';
		if (format === '12') {
			ampm = hours >= 12 ? 'PM' : 'AM';
			hours = hours % 12 || 12; // Convert 0 to 12
		}

		// Add leading zeros to hours, minutes, and seconds if necessary
		hours = hours < 10 ? '0' + hours : hours;
		const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
		const formattedSeconds = seconds < 10 ? '0' + seconds : seconds;

		// Build the time string
		let createTime = `${hours}:${formattedMinutes}`;

		if (showSeconds) {
			createTime += `:${formattedSeconds}`;
		}

		// Build the formatted time string
		let displayTime = format === '24'
			? createTime
			: `${createTime} ${ampm}`;

		return `${dayName}, ${displayTime}`;
	} catch (error) {
		console.error(`An error occurred in getClock(): ${error.message}`);
		return ''; // Return an empty string in case of an error
	}
};

/**
 * Function: isWeekend
 * Description: Checks if the given date falls on a weekend (Saturday or Sunday).
 *
 * @param {Date} date - The date to check. Defaults to the current date if not provided.
 * @returns {boolean} - Returns true if the date is a weekend, otherwise false.
 * 
 * @example
 * const result = isWeekend(new Date(2023, 8, 17)); // result is false
 */
const isWeekend = (date = new Date()) => {
	try {
		const day = date.getDay();
		return day === 0 || day === 6;
	} catch (error) {
		console.error(`An error occurred in isWeekend(): ${error.message}`);
		return false;
	}
}

/**
 * Function: isWeekday
 * Description: Checks if the given date is a weekday (Monday to Friday).
 *
 * @param {Date} date - The date to be checked. Default is the current date.
 * @returns {boolean} True if the date is a weekday, otherwise false.
 *
 * @example
 * const result = isWeekday(new Date('2023-08-19')); // Returns true if '2023-08-19' is a weekday.
 */
const isWeekday = (date = new Date()) => {
	try {
		const day = date.getDay(); // Sunday: 0, Monday: 1, ..., Saturday: 6
		return day >= 1 && day <= 5; // Weekdays are from Monday (1) to Friday (5)
	} catch (error) {
		console.error(`An error occurred in isWeekday(): ${error.message}`);
		return false;
	}
};

/**
 * Function:  formatDate
 * Description: Formats a given date string according to the specified format.
 * 
 * @param {string} date - The date string to be formatted.
 * @param {string} format - The desired format for the output date string. Defaults to 'd.m.Y'.
 * @param {*} defaultValue - The value to return if the input date is empty. Defaults to '1970-01-01'.
 * @param {string} lang - The language code, either 'en' (English), 'my' (Malay), or 'id' (Indonesian). Default is 'en'.
 * @returns {string|null} - The formatted date string or the defaultValue if the input date is empty.
 */
const formatDate = (date, format = 'd.m.Y', defaultValue = '1970-01-01', lang = 'en') => {
	// Check if the date is empty
	if (!date) {
		return defaultValue;
	}

	// Arrays to map format indicators to their corresponding values
	const monthsLong = {
		en: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
		my: ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'],
		id: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
	};

	const monthsShort = {
		en: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		my: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogos', 'Sep', 'Okt', 'Nov', 'Dis'],
		id: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
	};

	const daysLong = {
		en: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
		my: ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'],
		id: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
	};

	const daysShort = {
		en: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		my: ['Ahad', 'Isnin', 'Sel', 'Rabu', 'Khamis', 'Jum', 'Sab'],
		id: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab']
	};

	// Extract date components
	const d = new Date(date);
	const day = d.getDate();
	const month = d.getMonth() + 1;
	const year = d.getFullYear();
	const dayOfWeek = d.getDay();

	// Mapping of format indicators to their values
	const replaceFormats = {
		d: day.toString().padStart(2, '0'),
		D: daysShort[lang][dayOfWeek],
		j: day.toString(),
		l: daysLong[lang][dayOfWeek],
		F: monthsLong[lang][month - 1],
		m: month.toString().padStart(2, '0'),
		M: monthsShort[lang][month - 1],
		n: month.toString(),
		Y: year.toString(),
		y: year.toString().slice(-2)
	};

	// Replace format indicators with their corresponding values
	const formattedDate = format.replace(/(d|D|j|l|F|m|M|n|Y|y)/g, match => replaceFormats[match]);

	return formattedDate;
};