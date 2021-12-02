namespace trabajofinal.Data
{
    public class Evidence
    {
        public string XLabel { get; set; }
        public int XPos { get; set; }
        public string YLabel { get; set; }
        public int YPos { get; set; }
        public int Value { get; set; }
        public string Color { get; set; }

        public Evidence(string xLabel, string yLabel, int value)
        {
            XLabel = xLabel;
            YLabel = yLabel;
            Value = value;
        }

        public override string ToString()
        {
            return $"Evidence: {XLabel} {XPos} {YLabel} {YPos} {Value}";
        }

        public int GetRadius()
        {
            // Base radius 10 to make small numbers appear inside the circle
            return 10 + Value * 2;
        }
    }
}