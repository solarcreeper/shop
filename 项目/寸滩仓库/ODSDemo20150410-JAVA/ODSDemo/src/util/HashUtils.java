
package util;

import java.io.UnsupportedEncodingException;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.text.BreakIterator;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.BitSet;
import java.util.Random;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import sun.misc.BASE64Decoder;
import sun.misc.BASE64Encoder;

public class HashUtils {

	private HashUtils() {
	}

	public static final String replace(String string, String oldString,
			String newString) {
		if (string == null)
			return null;
		if (newString == null)
			return string;
		int i = 0;
		if ((i = string.indexOf(oldString, i)) >= 0) {
			char string2[] = string.toCharArray();
			char newString2[] = newString.toCharArray();
			int oLength = oldString.length();
			StringBuffer buf = new StringBuffer(string2.length);
			buf.append(string2, 0, i).append(newString2);
			i += oLength;
			int j;
			for (j = i; (i = string.indexOf(oldString, i)) > 0; j = i) {
				buf.append(string2, j, i - j).append(newString2);
				i += oLength;
			}

			buf.append(string2, j, string2.length - j);
			return buf.toString();
		} else {
			return string;
		}
	}

	public static final String replaceIgnoreCase(String line, String oldString,
			String newString) {
		if (line == null)
			return null;
		String lcLine = line.toLowerCase();
		String lcOldString = oldString.toLowerCase();
		int i = 0;
		if ((i = lcLine.indexOf(lcOldString, i)) >= 0) {
			char line2[] = line.toCharArray();
			char newString2[] = newString.toCharArray();
			int oLength = oldString.length();
			StringBuffer buf = new StringBuffer(line2.length);
			buf.append(line2, 0, i).append(newString2);
			i += oLength;
			int j;
			for (j = i; (i = lcLine.indexOf(lcOldString, i)) > 0; j = i) {
				buf.append(line2, j, i - j).append(newString2);
				i += oLength;
			}

			buf.append(line2, j, line2.length - j);
			return buf.toString();
		} else {
			return line;
		}
	}

	public static final String replaceIgnoreCase(String line, String oldString,
			String newString, int count[]) {
		if (line == null)
			return null;
		String lcLine = line.toLowerCase();
		String lcOldString = oldString.toLowerCase();
		int i = 0;
		if ((i = lcLine.indexOf(lcOldString, i)) >= 0) {
			int counter = 1;
			char line2[] = line.toCharArray();
			char newString2[] = newString.toCharArray();
			int oLength = oldString.length();
			StringBuffer buf = new StringBuffer(line2.length);
			buf.append(line2, 0, i).append(newString2);
			i += oLength;
			int j;
			for (j = i; (i = lcLine.indexOf(lcOldString, i)) > 0; j = i) {
				counter++;
				buf.append(line2, j, i - j).append(newString2);
				i += oLength;
			}

			buf.append(line2, j, line2.length - j);
			count[0] = counter;
			return buf.toString();
		} else {
			return line;
		}
	}

	public static final String replace(String line, String oldString,
			String newString, int count[]) {
		if (line == null)
			return null;
		int i = 0;
		if ((i = line.indexOf(oldString, i)) >= 0) {
			int counter = 1;
			char line2[] = line.toCharArray();
			char newString2[] = newString.toCharArray();
			int oLength = oldString.length();
			StringBuffer buf = new StringBuffer(line2.length);
			buf.append(line2, 0, i).append(newString2);
			i += oLength;
			int j;
			for (j = i; (i = line.indexOf(oldString, i)) > 0; j = i) {
				counter++;
				buf.append(line2, j, i - j).append(newString2);
				i += oLength;
			}

			buf.append(line2, j, line2.length - j);
			count[0] = counter;
			return buf.toString();
		} else {
			return line;
		}
	}

	public static final String stripTags(String in) {
		if (in == null)
			return null;
		else
			return stripTags(in, false);
	}

	public static final String stripTags(String in, boolean stripBRTag) {
		if (in == null)
			return null;
		int i = 0;
		int last = 0;
		char input[] = in.toCharArray();
		int len = input.length;
		StringBuffer out = new StringBuffer((int) ((double) len * 1.3D));
		for (; i < len; i++) {
			char ch = input[i];
			if (ch > '>')
				continue;
			if (ch == '<') {
				if (!stripBRTag && i + 3 < len && input[i + 1] == 'b'
						&& input[i + 2] == 'r' && input[i + 3] == '>') {
					i += 3;
					continue;
				}
				if (i > last) {
					if (last > 0)
						out.append(" ");
					out.append(input, last, i - last);
				}
				last = i + 1;
				continue;
			}
			if (ch == '>')
				last = i + 1;
		}

		if (last == 0)
			return in;
		if (i > last)
			out.append(input, last, i - last);
		return out.toString();
	}
	 /**    
     * BASE64解密   
     * @param key          
     * @return          
     * @throws Exception          
     */              
    public static byte[] decryptBASE64(String key) throws Exception {               
        return (new BASE64Decoder()).decodeBuffer(key);               
    }
    
    /**         
     * BASE64加密   
     * @param key          
     * @return          
     * @throws Exception          
     */              
    public static String encryptBASE64(byte[] key) throws Exception {               
        return (new BASE64Encoder()).encodeBuffer(key);
    } 
    
	public static final String escapeHTMLTags(String in) {
		if (in == null)
			return null;
		int i = 0;
		int last = 0;
		char input[] = in.toCharArray();
		int len = input.length;
		StringBuffer out = new StringBuffer((int) ((double) len * 1.3D));
		for (; i < len; i++) {
			char ch = input[i];
			if (ch > '>')
				continue;
			if (ch == '<') {
				if (i > last)
					out.append(input, last, i - last);
				last = i + 1;
				out.append(LT_ENCODE);
				continue;
			}
			if (ch == '>') {
				if (i > last)
					out.append(input, last, i - last);
				last = i + 1;
				out.append(GT_ENCODE);
				continue;
			}
			if (ch != '"')
				continue;
			if (i > last)
				out.append(input, last, i - last);
			last = i + 1;
			out.append(QUOTE_ENCODE);
		}

		if (last == 0)
			return in;
		if (i > last)
			out.append(input, last, i - last);
		return out.toString();
	}

	public static final synchronized String hash(String data) {
		if (digest == null)
			try {
				digest = MessageDigest.getInstance("MD5");
			} catch (NoSuchAlgorithmException nsae) {
				nsae.printStackTrace();
			}
		try {
			digest.update(data.getBytes("utf-8"));
		} catch (UnsupportedEncodingException e) {
			e.printStackTrace();
		}
		return encodeHex(digest.digest());
	}

	public static final String encodeHex(byte bytes[]) {
		StringBuffer buf = new StringBuffer(bytes.length * 2);
		for (int i = 0; i < bytes.length; i++) {
			if ((bytes[i] & 0xff) < 16)
				buf.append("0");
			buf.append(Long.toString(bytes[i] & 0xff, 16));
		}

		return buf.toString();
	}

	public static final byte[] decodeHex(String hex) {
		char chars[] = hex.toCharArray();
		byte bytes[] = new byte[chars.length / 2];
		int byteCount = 0;
		for (int i = 0; i < chars.length; i += 2) {
			int newByte = 0;
			newByte |= hexCharToByte(chars[i]);
			newByte <<= 4;
			newByte |= hexCharToByte(chars[i + 1]);
			bytes[byteCount] = (byte) newByte;
			byteCount++;
		}

		return bytes;
	}

	private static final byte hexCharToByte(char ch) {
		switch (ch) {
		case 48: // '0'
			return 0;

		case 49: // '1'
			return 1;

		case 50: // '2'
			return 2;

		case 51: // '3'
			return 3;

		case 52: // '4'
			return 4;

		case 53: // '5'
			return 5;

		case 54: // '6'
			return 6;

		case 55: // '7'
			return 7;

		case 56: // '8'
			return 8;

		case 57: // '9'
			return 9;

		case 97: // 'a'
			return 10;

		case 98: // 'b'
			return 11;

		case 99: // 'c'
			return 12;

		case 100: // 'd'
			return 13;

		case 101: // 'e'
			return 14;

		case 102: // 'f'
			return 15;

		case 58: // ':'
		case 59: // ';'
		case 60: // '<'
		case 61: // '='
		case 62: // '>'
		case 63: // '?'
		case 64: // '@'
		case 65: // 'A'
		case 66: // 'B'
		case 67: // 'C'
		case 68: // 'D'
		case 69: // 'E'
		case 70: // 'F'
		case 71: // 'G'
		case 72: // 'H'
		case 73: // 'I'
		case 74: // 'J'
		case 75: // 'K'
		case 76: // 'L'
		case 77: // 'M'
		case 78: // 'N'
		case 79: // 'O'
		case 80: // 'P'
		case 81: // 'Q'
		case 82: // 'R'
		case 83: // 'S'
		case 84: // 'T'
		case 85: // 'U'
		case 86: // 'V'
		case 87: // 'W'
		case 88: // 'X'
		case 89: // 'Y'
		case 90: // 'Z'
		case 91: // '['
		case 92: // '\\'
		case 93: // ']'
		case 94: // '^'
		case 95: // '_'
		case 96: // '`'
		default:
			return 0;
		}
	}

	public static String encodeBase64(String data) {
		byte bytes[] = null;
		try {
			bytes = data.getBytes("UTF-8");
		} catch (UnsupportedEncodingException uee) {
			uee.printStackTrace();
		}
		return encodeBase64(bytes);
	}

	public static String encodeBase64(byte data[]) {
		boolean lineSep = false;
		int sLen = data == null ? 0 : data.length;
		if (sLen == 0)
			return new String("");
		int eLen = (sLen / 3) * 3;
		int cCnt = (sLen - 1) / 3 + 1 << 2;
		int dLen = cCnt + (lineSep ? (cCnt - 1) / 76 << 1 : 0);
		char dArr[] = new char[dLen];
		int s = 0;
		int d = 0;
		int cc = 0;
		do {
			if (s >= eLen)
				break;
			int i = (data[s++] & 0xff) << 16 | (data[s++] & 0xff) << 8
					| data[s++] & 0xff;
			dArr[d++] = CA[i >>> 18 & 0x3f];
			dArr[d++] = CA[i >>> 12 & 0x3f];
			dArr[d++] = CA[i >>> 6 & 0x3f];
			dArr[d++] = CA[i & 0x3f];
			if (lineSep && ++cc == 19 && d < dLen - 2) {
				dArr[d++] = '\r';
				dArr[d++] = '\n';
				cc = 0;
			}
		} while (true);
		int left = sLen - eLen;
		if (left > 0) {
			int i = (data[eLen] & 0xff) << 10
					| (left != 2 ? 0 : (data[sLen - 1] & 0xff) << 2);
			dArr[dLen - 4] = CA[i >> 12];
			dArr[dLen - 3] = CA[i >>> 6 & 0x3f];
			dArr[dLen - 2] = left != 2 ? '=' : CA[i & 0x3f];
			dArr[dLen - 1] = '=';
		}
		return new String(dArr);
	}

	public static String URLEncode(String original, String charset)
			throws UnsupportedEncodingException {
		if (original == null)
			return null;
		byte octets[];
		try {
			octets = original.getBytes(charset);
		} catch (UnsupportedEncodingException error) {
			throw new UnsupportedEncodingException();
		}
		StringBuffer buf = new StringBuffer(octets.length);
		for (int i = 0; i < octets.length; i++) {
			char c = (char) octets[i];
			if (allowed_query.get(c)) {
				buf.append(c);
			} else {
				buf.append('%');
				byte b = octets[i];
				char hexadecimal = Character.forDigit(b >> 4 & 0xf, 16);
				buf.append(Character.toUpperCase(hexadecimal));
				hexadecimal = Character.forDigit(b & 0xf, 16);
				buf.append(Character.toUpperCase(hexadecimal));
			}
		}

		return buf.toString();
	}

	public static final String[] toLowerCaseWordArray(String text) {
		if (text == null || text.length() == 0)
			return new String[0];
		ArrayList<String> wordList = new ArrayList<String>();
		BreakIterator boundary = BreakIterator.getWordInstance();
		boundary.setText(text);
		int start = 0;
		for (int end = boundary.next(); end != -1; end = boundary.next()) {
			String tmp = text.substring(start, end).trim();
			tmp = replace(tmp, "+", "");
			tmp = replace(tmp, "/", "");
			tmp = replace(tmp, "\\", "");
			tmp = replace(tmp, "#", "");
			tmp = replace(tmp, "*", "");
			tmp = replace(tmp, ")", "");
			tmp = replace(tmp, "(", "");
			tmp = replace(tmp, "&", "");
			if (tmp.length() > 0)
				wordList.add(tmp);
			start = end;
		}

		return (String[]) wordList.toArray(new String[wordList.size()]);
	}

	public static final String randomString(int length) {
		if (length < 1)
			return null;
		char randBuffer[] = new char[length];
		for (int i = 0; i < randBuffer.length; i++)
			randBuffer[i] = numbersAndLetters[randGen.nextInt(71)];

		return new String(randBuffer);
	}

	public static final String chop(String string, int length) {
		if (string == null)
			return null;
		if (length <= 0)
			throw new IllegalArgumentException("Length must be > 0");
		if (string.length() <= length + 2) {
			return string;
		} else {
			StringBuffer buf = new StringBuffer(string.substring(0, length));
			buf.append("...");
			return buf.toString();
		}
	}

	public static final String chopAtWord(String string, int length,
			int minLength) {
		if (length < 2)
			throw new IllegalArgumentException("Length specified (" + length
					+ ") must be > 2");
		if (minLength >= length)
			throw new IllegalArgumentException(
					"minLength must be smaller than length");
		int sLength = string != null ? string.length() : -1;
		if (sLength < 1)
			return string;
		if (minLength != -1 && sLength < minLength)
			return string;
		if (minLength == -1 && sLength < length)
			return string;
		char charArray[] = string.toCharArray();
		if (sLength > length) {
			sLength = length;
			for (int i = 0; i < sLength - 1; i++) {
				if (charArray[i] == '\r' && charArray[i + 1] == '\n')
					return string.substring(0, i + 1);
				if (charArray[i] == '\n')
					return string.substring(0, i);
			}

			if (charArray[sLength - 1] == '\n')
				return string.substring(0, sLength - 1);
			for (int i = sLength - 1; i > 0; i--)
				if (charArray[i] == ' ')
					return string.substring(0, i).trim();

		} else if (minLength != -1 && sLength > minLength) {
			for (int i = 0; i < minLength; i++)
				if (charArray[i] == ' ')
					return string;

		}
		if (minLength > -1 && minLength <= string.length())
			return string.substring(0, minLength);
		else
			return string.substring(0, length);
	}

	public static final String chopAtWord(String string, int length) {
		return chopAtWord(string, length, -1);
	}

	public static String chopAtWordsAround(String input, String wordList[],
			int numChars) {
		if (input == null || "".equals(input.trim()) || wordList == null
				|| wordList.length == 0 || numChars == 0)
			return "";
		String lc = input.toLowerCase();
		for (int i = 0; i < wordList.length; i++) {
			int pos = lc.indexOf(wordList[i]);
			if (pos > -1) {
				int beginIdx = pos - numChars;
				if (beginIdx < 0)
					beginIdx = 0;
				int endIdx = pos + numChars;
				if (endIdx > input.length() - 1)
					endIdx = input.length() - 1;
				char chars[];
				for (chars = input.toCharArray(); beginIdx > 0
						&& chars[beginIdx] != ' ' && chars[beginIdx] != '\n'
						&& chars[beginIdx] != '\r'; beginIdx--)
					;
				for (; endIdx < input.length() && chars[endIdx] != ' '
						&& chars[endIdx] != '\n' && chars[endIdx] != '\r'; endIdx++)
					;
				return input.substring(beginIdx, endIdx);
			}
		}

		return input.substring(0, input.length() < 200 ? input.length() : 200);
	}

	public static final String highlightWords(String string, String words[],
			String startHighlight, String endHighlight) {
		if (string == null || words == null || startHighlight == null
				|| endHighlight == null)
			return null;
		StringBuffer regexp = new StringBuffer();
		regexp.append("(?i)\\b(");
		for (int x = 0; x < words.length; x++) {
			words[x] = words[x].replaceAll("([\\$\\?\\|\\/\\.])", "\\\\$1");
			regexp.append(words[x]);
			if (x != words.length - 1)
				regexp.append("|");
		}

		regexp.append(")");
		return string.replaceAll(regexp.toString(), startHighlight + "$1"
				+ endHighlight);
	}

	public static final String escapeForSQL(String string) {
		if (string == null)
			return null;
		if (string.length() == 0)
			return string;
		char input[] = string.toCharArray();
		int i = 0;
		int last = 0;
		int len = input.length;
		StringBuffer out = null;
		for (; i < len; i++) {
			char ch = input[i];
			if (ch != '\'')
				continue;
			if (out == null)
				out = new StringBuffer(len + 2);
			if (i > last)
				out.append(input, last, i - last);
			last = i + 1;
			out.append('\'').append('\'');
		}

		if (out == null)
			return string;
		if (i > last)
			out.append(input, last, i - last);
		return out.toString();
	}

	public static final String escapeForXML(String string) {
		if (string == null)
			return null;
		int i = 0;
		int last = 0;
		char input[] = string.toCharArray();
		int len = input.length;
		StringBuffer out = new StringBuffer((int) ((double) len * 1.3D));
		for (; i < len; i++) {
			char ch = input[i];
			if (ch > '>')
				continue;
			if (ch == '<') {
				if (i > last)
					out.append(input, last, i - last);
				last = i + 1;
				out.append(LT_ENCODE);
				continue;
			}
			if (ch == '>') {
				if (i > last)
					out.append(input, last, i - last);
				last = i + 1;
				out.append(GT_ENCODE);
				continue;
			}
			if (ch == '&') {
				if (i > last)
					out.append(input, last, i - last);
				last = i + 1;
				out.append(AMP_ENCODE);
				continue;
			}
			if (ch == '"') {
				if (i > last)
					out.append(input, last, i - last);
				last = i + 1;
				out.append(QUOTE_ENCODE);
				continue;
			}
			if (ch == '\n' || ch == '\r' || ch == '\t' || ch >= ' ')
				continue;
			if (i > last)
				out.append(input, last, i - last);
			last = i + 1;
		}

		if (last == 0)
			return string;
		if (i > last)
			out.append(input, last, i - last);
		return out.toString();
	}

	public static final String unescapeFromXML(String string) {
		string = replace(string, "&lt;", "<");
		string = replace(string, "&gt;", ">");
		string = replace(string, "&quot;", "\"");
		return replace(string, "&amp;", "&");
	}

	public static final String zeroPadString(String string, int length) {
		if (string == null || string.length() > length) {
			return string;
		} else {
			StringBuffer buf = new StringBuffer(length);
			buf.append(zeroArray, 0, length - string.length()).append(string);
			return buf.toString();
		}
	}

	public static boolean isValidEmailAddress(String addr) {
		if (addr == null)
			return false;
		addr = addr.trim();
		if (addr.length() == 0)
			return false;
		Matcher matcher = basicAddressPattern.matcher(addr);
		if (!matcher.matches())
			return false;
		String userPart = matcher.group(1);
		String domainPart = matcher.group(2);
		matcher = validUserPattern.matcher(userPart);
		if (!matcher.matches())
			return false;
		matcher = ipDomainPattern.matcher(domainPart);
		if (matcher.matches()) {
			for (int i = 1; i < 5; i++) {
				String num = matcher.group(i);
				if (num == null)
					return false;
				if (Integer.parseInt(num) > 254)
					return false;
			}

			return true;
		}
		matcher = domainPattern.matcher(domainPart);
		if (matcher.matches()) {
			String tld = matcher.group(matcher.groupCount());
			matcher = tldPattern.matcher(tld);
			return tld.length() == 3 || matcher.matches();
		} else {
			return false;
		}
	}

	private static final char QUOTE_ENCODE[] = "&quot;".toCharArray();
	private static final char AMP_ENCODE[] = "&amp;".toCharArray();
	private static final char LT_ENCODE[] = "&lt;".toCharArray();
	private static final char GT_ENCODE[] = "&gt;".toCharArray();
	private static Pattern basicAddressPattern;
	private static Pattern validUserPattern;
	private static Pattern domainPattern;
	private static Pattern ipDomainPattern;
	private static Pattern tldPattern;
	private static MessageDigest digest = null;
	private static final char CA[];
	private static final int IA[];
	private static final BitSet allowed_query;
	private static Random randGen = new Random();
	private static char numbersAndLetters[] = "0123456789abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"
			.toCharArray();
	private static final char zeroArray[] = "0000000000000000000000000000000000000000000000000000000000000000"
			.toCharArray();

	static {
		String basicAddress = "^([\\w\\.-]+)@([\\w\\.-]+)$";
		String specialChars = "\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
		String validChars = "[^ \f\n\r\t" + specialChars + "]";
		String atom = validChars + "+";
		String quotedUser = "(\"[^\"]+\")";
		String word = "(" + atom + "|" + quotedUser + ")";
		String validUser = "^" + word + "(\\." + word + ")*$";
		String domain = "^" + atom + "(\\." + atom + ")+$";
		String ipDomain = "^(\\d{1,3})\\.(\\d{1,3})\\.(\\d{1,3})\\.(\\d{1,3})$";
		String knownTLDs = "^\\.(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$";
		basicAddressPattern = Pattern.compile(basicAddress, 2);
		validUserPattern = Pattern.compile(validUser, 2);
		domainPattern = Pattern.compile(domain, 2);
		ipDomainPattern = Pattern.compile(ipDomain, 2);
		tldPattern = Pattern.compile(knownTLDs, 2);
		CA = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"
				.toCharArray();
		IA = new int[256];
		Arrays.fill(IA, -1);
		int i = 0;
		for (int iS = CA.length; i < iS; i++)
			IA[CA[i]] = i;

		IA[61] = 0;
		allowed_query = new BitSet(256);
		for (i = 48; i <= 57; i++)
			allowed_query.set(i);

		for (i = 97; i <= 122; i++)
			allowed_query.set(i);

		for (i = 65; i <= 90; i++)
			allowed_query.set(i);

		allowed_query.set(45);
		allowed_query.set(95);
		allowed_query.set(46);
		allowed_query.set(33);
		allowed_query.set(126);
		allowed_query.set(42);
		allowed_query.set(39);
		allowed_query.set(40);
		allowed_query.set(41);
	}
}