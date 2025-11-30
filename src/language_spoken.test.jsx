import { describe, it, expect, vi } from 'vitest';
import { capitalize, countryListLookup } from './language_spoken';

// ✅ Test for capitalize function
describe('capitalize function', () => {
  it("capitalizes language correctly", () => {
    expect(capitalize("english")).toBe("English");
    expect(capitalize("SPANISH")).toBe("Spanish");
    expect(capitalize("tagalog")).toBe("Tagalog");
  });
});

// ✅ Mock httpRequest para hindi naka-depende sa real API
vi.mock('./utils/http-request', () => ({
  default: vi.fn(() => Promise.resolve({
    data: {
      AR: { name: "Argentina" },
      BZ: { name: "Belize" },
      BO: { name: "Bolivia" }
    }
  }))
}));

// ✅ Test for countryListLookup
describe('languageSpoken Tests', () => {
  it("fetches countries where a language is spoken", async () => {
    const mockCallback = vi.fn();
    const result = await countryListLookup("spanish", mockCallback);

    expect(mockCallback).toHaveBeenCalled();
    expect(Array.isArray(result)).toBe(true);
    expect(result.length).toBeGreaterThan(0);   // ✅ ngayon may laman
    expect(result).toContain("Argentina");
  });
});
