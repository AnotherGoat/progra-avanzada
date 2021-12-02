using System;
using System.Collections.Generic;
using System.Linq;

namespace trabajofinal.Data
{
    public class EvidenceGraph
    {
        public List<Evidence> Evidences { get; set; } = new List<Evidence>();
        // Separation between each element
        public int Separation { get; set; }

        private static List<string> Colors = new List<string>();

        public EvidenceGraph(string input, string colors)
        {
            // Cleans input data and parses it to a list
            input = SimplifyInput(input);
            var evidences = ParseEvidences(input);

            // Initializes the list of colors based on input
            Colors = ParseColors(colors);

            // Calculates the position of each evidence using the separation (based on max radius)
            Separation = evidences.Select(e => e.Value).Max() * 3 + 10;
            Evidences = CalculatePositions(evidences);
        }

        // Simplifies input data to make it easier to parse
        // This implies that none of the X/Y axis labels contains the characters "{", "}", "(", ")", ",", ";" or whitespace, because they will be removed on this step
        private string SimplifyInput(string input)
        {
            return input.Replace(" ", "").Replace("{", "").Replace("}", "").Replace("\n", "")
                    .Replace("),(", ";").Replace("(", "").Replace(")", "").Replace("\"", "");
        }

        // Parses evidence data from simplified input
        private List<Evidence> ParseEvidences(string input)
        {
            var evidences = new List<Evidence>();

            foreach (var evidence in input.Split(';'))
            {
                var data = evidence.Split(',');
                var x = data[0];
                var y = data[1];
                var value = Int32.Parse(data[2]);

                evidences.Add(new Evidence(x, y, value));
            }

            return evidences;
        }

        // Parses colors from text area input
        private List<string> ParseColors(string input) {
            return new List<string>(input.Replace(" ", "").Replace("\"", "").Split(","));
        }

        // Calculates X and Y postition of each evidence
        private List<Evidence> CalculatePositions(List<Evidence> evidences)
        {
            // Extracts every unique X and Y label value
            var xValues = evidences.Select(e => e.XLabel).Distinct().ToList();
            // Y axis is reversed to make it match the example picture
            var yValues = evidences.Select(e => e.YLabel).Distinct().Reverse().ToList();

            foreach (var evidence in evidences) {
                evidence.XPos = Separation * (1 + xValues.IndexOf(evidence.XLabel));
                evidence.YPos = Separation * (1 + yValues.IndexOf(evidence.YLabel));

                // Color also depends on X label
                var colorIndex = xValues.IndexOf(evidence.XLabel) % Colors.Count;
                evidence.Color = Colors[colorIndex];
            }

            return evidences;
        }

        // Used for the X axis labels
        public int GetYLimit() {
            return Evidences.Max(e => e.YPos) + Separation;

        }

        // The next 6 methods are used to draw the background lines
        public int GetMinX() {
            return Separation / 2;
        }

        public int GetMaxX() {
            return Evidences.Max(e => e.XPos) + Separation / 2;
        }

        public int GetMinY() {
            return Separation / 2;
        }

        public int GetMaxY() {
            return Evidences.Max(e => e.YPos) + Separation / 2;
        }

        public List<int> GetXPositions() {
            return Evidences.Select(e => e.XPos).Distinct().ToList();
        }

        public List<int> GetYPositions() {
            return Evidences.Select(e => e.YPos).Distinct().ToList();
        }
    }
}